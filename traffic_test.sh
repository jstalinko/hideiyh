#!/bin/bash

# Configuration - CHANGE THESE VALUES
HIDEIYH_API_URL="http://hideiyh.pw/api/validate-visitor"  # Direct API endpoint
HIDEIYH_APIKEY="XHID-6485AB4455025F70227BA66B59BF64FE"                   # Your API key
SHORTLINK="lb2fjs"                      # Your shortlink
DOMAIN="localhost:8000"                            # Your domain

# Test parameters
TOTAL_REQUESTS=500                             # Total number of requests to send
CONCURRENT=10                                  # Concurrent connections
DELAY_MIN=0                                    # Minimum delay between requests (in milliseconds)
DELAY_MAX=500                                  # Maximum delay between requests (in milliseconds)

# User agents for testing (add more for variety)
USER_AGENTS=(
    "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36"
    "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.0 Safari/605.1.15"
    "Mozilla/5.0 (Linux; Android 11; SM-G991B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.72 Mobile Safari/537.36"
    "Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.0 Mobile/15E148 Safari/604.1"
    "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:89.0) Gecko/20100101 Firefox/89.0"
)

# Referrers for testing
REFERRERS=(
    "https://www.google.com"
    "https://www.facebook.com"
    "https://www.instagram.com"
    "https://www.twitter.com"
    "https://www.youtube.com"
    "https://www.reddit.com"
    "https://www.bing.com"
    "none"
)

# IP address ranges for testing
IP_RANGES=(
    "192.168.1"
    "10.0.0"
    "172.16.0"
    "45.123.45"
    "87.65.43"
    "203.198.23"
    "77.88.99"
)

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[0;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Files to save results
RESULTS_FILE="hideiyh_test_results.txt"
LOG_FILE="hideiyh_test_log.txt"
REDIRECT_FILE="hideiyh_redirect_results.txt"

# Clear previous results
> $RESULTS_FILE
> $LOG_FILE
> $REDIRECT_FILE

# Print test configuration
echo -e "${YELLOW}====== HIDEIYH API FLOOD TEST ======${NC}"
echo -e "${YELLOW}API URL:${NC} $HIDEIYH_API_URL"
echo -e "${YELLOW}API Key:${NC} $HIDEIYH_APIKEY"
echo -e "${YELLOW}Shortlink:${NC} $SHORTLINK"
echo -e "${YELLOW}Total Requests:${NC} $TOTAL_REQUESTS"
echo -e "${YELLOW}Concurrent Connections:${NC} $CONCURRENT"
echo -e "${YELLOW}Request Delay Range:${NC} $DELAY_MIN-$DELAY_MAX ms"
echo -e "${YELLOW}===================================${NC}\n"

# Initialize counters
success_count=0
error_count=0
redirect_count=0
start_time=$(date +%s)

# Arrays to track statistics
declare -A status_codes
declare -A redirect_urls

# Function to generate a random IP from our ranges
get_random_ip() {
    local range=${IP_RANGES[$RANDOM % ${#IP_RANGES[@]}]}
    local octet3=$((RANDOM % 255))
    local octet4=$((RANDOM % 255))
    echo "$range.$octet3.$octet4"
}

# Function to track progress
show_progress() {
    local completed=$1
    local total=$2
    local percent=$((completed * 100 / total))
    local completed_bar=$((completed * 50 / total))
    
    # Create progress bar
    local progress="["
    for ((i=0; i<completed_bar; i++)); do
        progress+="#"
    done
    for ((i=completed_bar; i<50; i++)); do
        progress+="."
    done
    progress+="]"
    
    # Calculate estimated time remaining
    local current_time=$(date +%s)
    local elapsed=$((current_time - start_time))
    local rate=$(echo "scale=2; $completed / $elapsed" | bc 2>/dev/null)
    if [[ $rate == "" || $rate == "0" ]]; then
        rate="0.01"  # Avoid division by zero
    fi
    local remaining=$(echo "scale=0; ($total - $completed) / $rate" | bc 2>/dev/null)
    
    # Format time remaining
    local mins=$((remaining / 60))
    local secs=$((remaining % 60))
    
    # Update progress bar
    echo -ne "\r${GREEN}Progress:${NC} $progress ${GREEN}$percent%${NC} ($completed/$total) - ETA: ${mins}m ${secs}s"
}

# Create a temporary file for process IDs
PID_FILE=$(mktemp)

# Track how many processes are running
running=0
completed=0

# Function to run a single request
run_request() {
    local request_id=$1
    
    # Generate random values for this request
    local ua=${USER_AGENTS[$RANDOM % ${#USER_AGENTS[@]}]}
    local ua_encoded=$(echo -n "$ua" | base64)
    local referrer=${REFERRERS[$RANDOM % ${#REFERRERS[@]}]}
    local visitor_ip=$(get_random_ip)
    
    # Random delay to prevent exact same timing
    sleep 0.$(($RANDOM % ($DELAY_MAX - $DELAY_MIN + 1) + $DELAY_MIN))
    
    # Build the curl command with proper headers and options
    # Note: We're using -L to automatically follow redirects, and -i to include headers in output
    local response=$(curl -s -i -L -w "\n%{http_code}" \
        -H "visitor-referer: $referrer" \
        -H "domain: $DOMAIN" \
        -H "apikey: $HIDEIYH_APIKEY" \
        -H "shortlink: $SHORTLINK" \
        -H "visitor-ip: $visitor_ip" \
        -H "visitor-useragent: $ua_encoded" \
        -H "User-Agent: hideiyh@php" \
        "$HIDEIYH_API_URL/$HIDEIYH_APIKEY" )
    
    # Extract the final status code
    local status_code=$(echo "$response" | tail -n1)
    
    # Update status code count
    status_codes["$status_code"]=$((${status_codes["$status_code"]} + 1))
    
    # Check for success (200 OK)
    if [[ $status_code == 2* ]]; then
        ((success_count++))
        
        # Extract redirect URL from JSON response
        local redirect_url=$(echo "$response" | grep -o '"redirect_url":"[^"]*"' | head -1 | awk -F '"' '{print $4}')
        
        if [[ -n "$redirect_url" ]]; then
            ((redirect_count++))
            redirect_urls["$redirect_url"]=$((${redirect_urls["$redirect_url"]} + 1))
            
            # Log successful redirect
            echo "[REQUEST $request_id] Redirect URL: $redirect_url" >> $REDIRECT_FILE
        fi
    else
        ((error_count++))
        
        # Extract response body for logging
        local headers_and_body=$(echo "$response" | sed '$d')
        
        # Log errors to file
        echo "[ERROR] Request ID: $request_id, Status: $status_code, IP: $visitor_ip" >> $LOG_FILE
        echo "Request Headers:" >> $LOG_FILE
        echo "  visitor-referer: $referrer" >> $LOG_FILE
        echo "  domain: $DOMAIN" >> $LOG_FILE
        echo "  apikey: $HIDEIYH_APIKEY" >> $LOG_FILE
        echo "  shortlink: $SHORTLINK" >> $LOG_FILE
        echo "  visitor-ip: $visitor_ip" >> $LOG_FILE
        echo "  visitor-useragent: $ua_encoded" >> $LOG_FILE
        echo "Response:" >> $LOG_FILE
        echo "$headers_and_body" >> $LOG_FILE
        echo "----------------------------------------" >> $LOG_FILE
    fi
    
    # Update completed count and show progress
    ((completed++))
    show_progress $completed $TOTAL_REQUESTS
}

echo -e "${GREEN}Starting test...${NC}"

# First, perform a single test request to check if the API is working correctly
echo -e "${BLUE}Performing initial test request...${NC}"
test_response=$(curl -s -L -i -H "visitor-referer: https://www.google.com" \
    -H "domain: $DOMAIN" \
    -H "apikey: $HIDEIYH_APIKEY" \
    -H "shortlink: $SHORTLINK" \
    -H "visitor-ip: 8.8.8.8" \
    -H "visitor-useragent: $(echo -n "Mozilla/5.0 (Windows NT 10.0; Win64; x64)" | base64)" \
    -H "User-Agent: hideiyh@php" \
    "$HIDEIYH_API_URL/$HIDEIYH_APIKEY" )

echo -e "${BLUE}Initial test response:${NC}"
echo "$test_response" | head -20
echo "..."

echo -e "\n${YELLOW}Press Enter to continue with the full test, or Ctrl+C to abort${NC}"
read -r

# Run requests in parallel up to CONCURRENT limit
for ((i=1; i<=TOTAL_REQUESTS; i++)); do
    # Check if we're at max concurrency
    while [[ $running -ge $CONCURRENT ]]; do
        # Check which processes have finished
        for pid in $(cat $PID_FILE); do
            if ! kill -0 $pid 2>/dev/null; then
                # Process completed, remove from file
                sed -i "/^$pid$/d" $PID_FILE
                ((running--))
            fi
        done
        # Small delay to prevent CPU hogging
        sleep 0.1
    done
    
    # Run request in background
    run_request $i &
    
    # Store process ID
    echo $! >> $PID_FILE
    ((running++))
    
    # Show initial progress update
    show_progress $completed $TOTAL_REQUESTS
done

# Wait for all remaining processes to complete
wait

# Calculate final statistics
end_time=$(date +%s)
total_time=$((end_time - start_time))
requests_per_sec=$(echo "scale=2; $TOTAL_REQUESTS / $total_time" | bc)

# Print summary
echo -e "\n\n${YELLOW}====== TEST RESULTS ======${NC}"
echo -e "${GREEN}Completed:${NC} $TOTAL_REQUESTS requests in $total_time seconds"
echo -e "${GREEN}Rate:${NC} $requests_per_sec requests/second"
echo -e "${GREEN}Success:${NC} $success_count requests"
echo -e "${RED}Errors:${NC} $error_count requests"
echo -e "${BLUE}Redirects:${NC} $redirect_count redirects found"
echo -e "${YELLOW}==========================${NC}\n"

# Print status code distribution
echo -e "${YELLOW}Status Code Distribution:${NC}"
for status in "${!status_codes[@]}"; do
    echo -e "  ${BLUE}$status:${NC} ${status_codes[$status]} requests"
done

# Print top redirect URLs
if [[ $redirect_count -gt 0 ]]; then
    echo -e "\n${YELLOW}Top 5 Redirect URLs:${NC}"
    count=0
    for url in $(for k in "${!redirect_urls[@]}"; do echo "$k ${redirect_urls[$k]}"; done | sort -rn -k2 | head -5 | cut -d' ' -f1); do
        count=$(echo "scale=2; ${redirect_urls[$url]} * 100 / $redirect_count" | bc)
        echo -e "  ${BLUE}$url${NC}: ${redirect_urls[$url]} redirects ($count%)"
    done
fi

# Save results to file
echo "====== HIDEIYH API FLOOD TEST RESULTS ======" > $RESULTS_FILE
echo "API URL: $HIDEIYH_API_URL" >> $RESULTS_FILE
echo "API Key: $HIDEIYH_APIKEY" >> $RESULTS_FILE
echo "Shortlink: $SHORTLINK" >> $RESULTS_FILE
echo "Total Requests: $TOTAL_REQUESTS" >> $RESULTS_FILE
echo "Concurrent Connections: $CONCURRENT" >> $RESULTS_FILE
echo "Request Delay Range: $DELAY_MIN-$DELAY_MAX ms" >> $RESULTS_FILE
echo "Completed: $TOTAL_REQUESTS requests in $total_time seconds" >> $RESULTS_FILE
echo "Rate: $requests_per_sec requests/second" >> $RESULTS_FILE
echo "Success: $success_count requests" >> $RESULTS_FILE
echo "Errors: $error_count requests" >> $RESULTS_FILE
echo "Redirects: $redirect_count redirects found" >> $RESULTS_FILE
echo "=============================================" >> $RESULTS_FILE

# Save status code distribution
echo -e "\nStatus Code Distribution:" >> $RESULTS_FILE
for status in "${!status_codes[@]}"; do
    echo "  $status: ${status_codes[$status]} requests" >> $RESULTS_FILE
done

# Save top redirect URLs
if [[ $redirect_count -gt 0 ]]; then
    echo -e "\nTop 10 Redirect URLs:" >> $RESULTS_FILE
    for url in $(for k in "${!redirect_urls[@]}"; do echo "$k ${redirect_urls[$k]}"; done | sort -rn -k2 | head -10 | cut -d' ' -f1); do
        count=$(echo "scale=2; ${redirect_urls[$url]} * 100 / $redirect_count" | bc)
        echo "  $url: ${redirect_urls[$url]} redirects ($count%)" >> $RESULTS_FILE
    done
fi

echo -e "${GREEN}Results saved to $RESULTS_FILE${NC}"
echo -e "${GREEN}Error logs saved to $LOG_FILE${NC}"
echo -e "${GREEN}Redirect details saved to $REDIRECT_FILE${NC}"

# Clean up temporary file
rm $PID_FILE