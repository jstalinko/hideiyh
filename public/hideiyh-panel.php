<?php
// Check if panel parameter exists
if(isset($_GET['panel'])) {
    require_once __DIR__ . '/hideiyh-config.php';
    
    // Define category groups for better organization
    $categories = [
        'Basic Information' => [
            'id', 'user_id', 'shortlink', 'apikey', 'domain', 'active'
        ],
        'Traffic Statistics' => [
            'clicks', 'white_page_clicks', 'bot_page_clicks', 'offer_page_clicks'
        ],
        'Page Configuration' => [
            'bot_page_url', 'white_page_url', 'offer_page_url',
            'render_bot_page_method', 'render_white_page_method', 'render_offer_page_method'
        ],
        'Traffic Filters' => [
            'allowed_country', 'allowed_params', 'block_no_referer', 
            'block_vpn', 'block_bot', 'allowed_device', 'allowed_platform', 'anti_loop_max'
        ],
        'Timestamps' => [
            'created_at', 'updated_at'
        ]
    ];
    
    // Function to format values for display
    function format_value($key, $value) {
        if (is_array($value)) {
            return implode(', ', $value);
        } elseif ($key == 'active' || $key == 'block_no_referer' || $key == 'block_vpn' || $key == 'block_bot') {
            return $value == '1' ? '<span class="badge bg-success">Enabled</span>' : '<span class="badge bg-danger">Disabled</span>';
        } elseif (strpos($key, '_url') !== false) {
            return '<a href="' . htmlspecialchars($value) . '" target="_blank">' . htmlspecialchars($value) . '</a>';
        } elseif (strpos($key, '_at') !== false) {
            return date('F j, Y g:i A', strtotime($value));
        } else {
            return htmlspecialchars($value);
        }
    }
    
    // Function to get a readable label from key
    function get_label($key) {
        $key = str_replace('_', ' ', $key);
        return ucwords($key);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HideIYH Configuration Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .config-container {
            max-width: 1200px;
            margin: 20px auto;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }
        .card-header {
            background-color: #4361ee;
            color: white;
            font-weight: 600;
            padding: 15px 20px;
        }
        .card-body {
            padding: 0;
        }
        .table {
            margin-bottom: 0;
        }
        .table td, .table th {
            padding: 12px 20px;
            vertical-align: middle;
        }
        .key-column {
            width: 35%;
            font-weight: 500;
            color: #495057;
        }
        .value-column {
            width: 65%;
            color: #212529;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.02);
        }
        .badge {
            padding: 6px 10px;
            font-weight: 500;
            border-radius: 4px;
        }
        .bg-success {
            background-color: #4CAF50 !important;
        }
        .bg-danger {
            background-color: #F44336 !important;
        }
        .bg-warning {
            background-color: #FF9800 !important;
        }
        .header {
            background-color: #3f51b5;
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .action-buttons {
            margin-top: 20px;
            margin-bottom: 40px;
            text-align: center;
        }
        .btn {
            padding: 10px 20px;
            margin: 0 5px;
            border-radius: 5px;
            font-weight: 500;
        }
        .btn-primary {
            background-color: #4361ee;
            border-color: #4361ee;
        }
        .btn-primary:hover {
            background-color: #3a56d4;
            border-color: #3a56d4;
        }
        .btn-danger {
            background-color: #F44336;
            border-color: #F44336;
        }
        .btn-danger:hover {
            background-color: #e53935;
            border-color: #e53935;
        }
        .stats-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 30px;
        }
        .stat-card {
            flex: 1;
            min-width: 200px;
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .stat-value {
            font-size: 28px;
            font-weight: 700;
            margin: 10px 0;
        }
        .stat-label {
            color: #6c757d;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .stat-icon {
            font-size: 24px;
            margin-bottom: 15px;
        }
        .stat-card:nth-child(1) .stat-icon {
            color: #4361ee;
        }
        .stat-card:nth-child(2) .stat-icon {
            color: #3a86ff;
        }
        .stat-card:nth-child(3) .stat-icon {
            color: #4CAF50;
        }
        .stat-card:nth-child(4) .stat-icon {
            color: #F44336;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1><i class="fas fa-shield-alt me-2"></i> HideIyh Panel</h1>
                <div class="text-end">
                    <h5>Shortlink: <?php echo htmlspecialchars($hideiyh_config['shortlink']); ?></h5>
                    <p class="mb-0">Domain: <?php echo htmlspecialchars($hideiyh_config['domain']); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="container config-container">
        <!-- Stats Overview -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-mouse-pointer"></i>
                </div>
                <div class="stat-value"><?php echo htmlspecialchars($hideiyh_config['clicks']); ?></div>
                <div class="stat-label">Total Clicks</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="stat-value"><?php echo htmlspecialchars($hideiyh_config['white_page_clicks']); ?></div>
                <div class="stat-label">White Page Clicks</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-value"><?php echo htmlspecialchars($hideiyh_config['offer_page_clicks']); ?></div>
                <div class="stat-label">Offer Page Clicks</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="stat-value"><?php echo htmlspecialchars($hideiyh_config['bot_page_clicks']); ?></div>
                <div class="stat-label">Bot Page Clicks</div>
            </div>
        </div>

       
        <div class="action-buttons">
            <a href="#" class="btn btn-secondary">
                <i class="fas fa-sync-alt me-2"></i> Refresh Configuration
            </a>
            <a href="#" class="btn btn-primary">
                <i class="fas fa-copy me-2"></i> Copy Link
            </a>
            <a href="#" class="btn btn-success">
                <i class="fas fa-external-link-alt me-2"></i> Visit Link
            </a>
        </div>

        <!-- Configuration Details -->
        <?php foreach ($categories as $category => $keys): ?>
        <div class="card">
            <div class="card-header">
                <?php echo htmlspecialchars($category); ?>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tbody>
                        <?php foreach ($keys as $key): ?>
                        <tr>
                            <td class="key-column"><?php echo get_label($key); ?></td>
                            <td class="value-column"><?php echo format_value($key, $hideiyh_config[$key]); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endforeach; ?>

       
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
} else {
    // If panel parameter is not set, show an error or redirect
    header('Location: index.php');
    exit;
}
?>