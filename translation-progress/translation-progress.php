<?php
/*
Plugin Name: TranslatePress Progress Monitor
Description: Monitor translation progress for TranslatePress
Author: Apprcn
Author URI: https://www.apprcn.com
Version: 1.0
*/

if (!defined('ABSPATH')) {
    exit;
}

// 常量定义
define('TP_PROGRESS_VERSION', '1.5.0');
define('TP_PROGRESS_MINIMUM_WP_VERSION', '5.0');
define('TP_PROGRESS_MINIMUM_PHP_VERSION', '7.0');
define('TP_PROGRESS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('TP_PROGRESS_PLUGIN_URL', plugin_dir_url(__FILE__));

// 添加语言文本函数
function tp_get_text($key) {
    $options = get_option('tp_progress_settings');
    $language = isset($options['display_language']) ? 
        $options['display_language'] : 
        (get_locale() === 'zh_CN' ? 'zh_CN' : 'en_US');
    
    $texts = array(
        'en_US' => array(
            'settings_title' => 'Translation Progress Monitor Settings',
            'settings_saved' => 'Settings saved.',
            'refresh_interval' => 'Auto Refresh Interval',
            'show_changes' => 'Show Progress Changes',
            'show_changes_desc' => 'Show progress changes since last view',
            'debug_mode' => 'Debug Mode',
            'debug_mode_desc' => 'Enable debug mode (show detailed database query information and possible errors)',
            'display_language' => 'Display Language',
            'debug_info' => 'Debug Information',
            'trp_settings' => 'TranslatePress Settings Check',
            'default_language' => 'Default Language',
            'target_languages' => 'Target Languages',
            'database_check' => 'Database Tables Check',
            'table_exists' => 'exists and accessible',
            'table_not_exists' => 'does not exist or not accessible',
            'total_records' => 'Total Records',
            'empty_originals' => 'Empty Originals',
            'empty_translations' => 'Empty Translations',
            'wp_environment' => 'WordPress Environment',
            'current_settings' => 'Current Plugin Settings',
            'debug_mode_status' => 'Debug Mode',
            'show_changes_status' => 'Show Changes',
            'refresh_interval_status' => 'Refresh Interval',
            'enabled' => 'Enabled',
            'disabled' => 'Disabled',
            'seconds' => 'seconds',
            'translation_progress' => 'Translation Progress',
            'from_to' => 'From %s to %s',
            'current_progress' => 'Current Progress',
            'translated_count' => 'Translated',
            'compared_to_last' => 'Compared to last view (%s ago)',
            'total_content_change' => 'Total content to translate',
            'progress_change' => 'Progress change',
            'previous_stats' => 'Previous stats',
            'current_stats' => 'Current stats',
            'refresh_countdown' => 'Page will refresh in %d seconds',
            'missing_columns' => 'Warning: Missing required columns',
            'sql_error' => 'SQL Error',
            'no_progress_data' => 'No translation progress data available.',
            'not_set' => 'Not set',
            'no_trp_settings' => 'TranslatePress settings not found. Please configure TranslatePress first.',
            'monitor' => 'Monitor',
            'settings' => 'Settings',
            'translation_progress_menu' => 'Translation Progress',
            'version' => 'Version',
            'recent_translations' => 'Recent Translations',
            'original_text' => 'Original Text',
            'translated_text' => 'Translated Text',
            'block_type' => 'Block Type',
            // 时间间隔选项
            'interval_1min' => '1 minute',
            'interval_5min' => '5 minutes',
            'interval_10min' => '10 minutes',
            'interval_30min' => '30 minutes',
            'interval_1hour' => '1 hour',
            'refresh_now' => 'Refresh Now',
            'table_name' => 'Table Name',
            'status' => 'Status',
            'records' => 'Total Records',
            'empty_translations' => 'Empty Translations',
            'table_exists' => 'Table exists',
            'table_not_exists' => 'Table does not exist',
            'memory_usage' => 'Memory Usage',
            'max_execution_time' => 'Max Execution Time',
            'seconds' => ' seconds',
            'enabled' => 'Enabled',
            'disabled' => 'Disabled',
            'database_info' => 'Database Connection Information',
            'db_name' => 'Database Name',
            'db_host' => 'Database Host',
            'table_prefix' => 'Table Prefix',
            'db_charset' => 'Database Charset',
            'db_collate' => 'Database Collation',
        ),
        'zh_CN' => array(
            'settings_title' => '翻译进度监控设置',
            'settings_saved' => '设置已保存。',
            'refresh_interval' => '自动刷新间隔',
            'show_changes' => '显示进度变化',
            'show_changes_desc' => '显示与上次查看时的进度变化',
            'debug_mode' => '调试模式',
            'debug_mode_desc' => '启用调试模式（显示详细的数据库查询信息和可能的错误）',
            'display_language' => '显示语言',
            'debug_info' => '调试信息',
            'trp_settings' => 'TranslatePress 设置检查',
            'default_language' => '默认语言',
            'target_languages' => '目标语言',
            'database_check' => '数据库表检查',
            'table_exists' => '存在且可用',
            'table_not_exists' => '不存在或无法访问',
            'total_records' => '总记录数',
            'empty_originals' => '空原文记录',
            'empty_translations' => '空翻译记录',
            'wp_environment' => 'WordPress 环境',
            'current_settings' => '当前插件设置',
            'debug_mode_status' => '调试模式',
            'show_changes_status' => '显示变化',
            'refresh_interval_status' => '刷新间隔',
            'enabled' => '启用',
            'disabled' => '禁用',
            'seconds' => '秒',
            'translation_progress' => '翻译进度',
            'from_to' => '从 %s 翻译到 %s',
            'current_progress' => '当前进度',
            'translated_count' => '已翻译',
            'compared_to_last' => '与上次查看相比（%s前）',
            'total_content_change' => '需要翻译的总内容',
            'progress_change' => '进度变化',
            'previous_stats' => '上次统计',
            'current_stats' => '当前统计',
            'refresh_countdown' => '页面将在 %d 秒后自动刷新',
            'missing_columns' => '警告：缺少必要的列',
            'sql_error' => 'SQL错误',
            'no_progress_data' => '暂无翻译进度数据。',
            'not_set' => '未设置',
            'no_trp_settings' => '未找到 TranslatePress 设置。请先配置 TranslatePress。',
            'monitor' => '监控面板',
            'settings' => '设置',
            'translation_progress_menu' => '翻译进度',
            'version' => '版本',
            'recent_translations' => '最近翻译的内容',
            'original_text' => '原文',
            'translated_text' => '译文',
            'block_type' => '类型',
            // 时间间隔选项
            'interval_1min' => '1分钟',
            'interval_5min' => '5分钟',
            'interval_10min' => '10分钟',
            'interval_30min' => '30分钟',
            'interval_1hour' => '1小时',
            'refresh_now' => '立即刷新',
            'table_name' => '数据表名称',
            'status' => '状态',
            'records' => '总记录数',
            'empty_translations' => '未翻译条目',
            'table_exists' => '表存在',
            'table_not_exists' => '表不存在',
            'memory_usage' => '内存使用',
            'max_execution_time' => '最大执行时间',
            'seconds' => ' 秒',
            'enabled' => '已启用',
            'disabled' => '已禁用',
            'database_info' => '数据库连接信息',
            'db_name' => '数据库名称',
            'db_host' => '数据库主机',
            'table_prefix' => '表前缀',
            'db_charset' => '数据库字符集',
            'db_collate' => '数据库排序规则',
        )
    );
    
    return isset($texts[$language][$key]) ? $texts[$language][$key] : $texts['en_US'][$key];
}

// 添加菜单
function tp_progress_menu() {
    add_menu_page(
        tp_get_text('translation_progress_menu'),
        tp_get_text('translation_progress_menu'),
        'manage_options',
        'tp-progress',
        'tp_progress_page',
        'dashicons-translation',
        100
    );
    
    add_submenu_page(
        'tp-progress',
        tp_get_text('monitor'),
        tp_get_text('monitor'),
        'manage_options',
        'tp-progress',
        'tp_progress_page'
    );
    
    add_submenu_page(
        'tp-progress',
        tp_get_text('settings'),
        tp_get_text('settings'),
        'manage_options',
        'tp-progress-settings',
        'tp_progress_settings_page'
    );
}
add_action('admin_menu', 'tp_progress_menu');

// 添加设置
function tp_progress_settings_init() {
    // 注册设置
    register_setting(
        'tp_progress', // option group
        'tp_progress_settings', // option name
        array(
            'sanitize_callback' => 'tp_validate_settings',
            'default' => array(
                'refresh_interval' => 60,
                'show_changes' => true,
                'debug_mode' => false,
                'display_language' => get_locale() === 'zh_CN' ? 'zh_CN' : 'en_US'
            )
        )
    );
    
    // 添加设置部分
    add_settings_section(
        'tp_progress_settings_section',
        tp_get_text('settings_title'),
        null,
        'tp_progress' // 这里改为与 settings_fields() 参数匹配
    );
    
    // 添加设置字段
    add_settings_field(
        'refresh_interval',
        tp_get_text('refresh_interval'),
        'tp_refresh_interval_callback',
        'tp_progress',
        'tp_progress_settings_section'
    );
    
    add_settings_field(
        'show_changes',
        tp_get_text('show_changes'),
        'tp_show_changes_callback',
        'tp_progress',
        'tp_progress_settings_section'
    );
    
    add_settings_field(
        'debug_mode',
        tp_get_text('debug_mode'),
        'tp_debug_mode_callback',
        'tp_progress',
        'tp_progress_settings_section'
    );
    
    add_settings_field(
        'display_language',
        tp_get_text('display_language'),
        'tp_display_language_callback',
        'tp_progress',
        'tp_progress_settings_section'
    );
}
add_action('admin_init', 'tp_progress_settings_init');

// 设置回调函数
function tp_refresh_interval_callback() {
    $options = get_option('tp_progress_settings', array());
    $current_interval = isset($options['refresh_interval']) ? $options['refresh_interval'] : 60;
    
    $intervals = array(
        60 => tp_get_text('interval_1min'),
        300 => tp_get_text('interval_5min'),
        600 => tp_get_text('interval_10min'),
        1800 => tp_get_text('interval_30min'),
        3600 => tp_get_text('interval_1hour')
    );
    
    echo "<select id='refresh_interval' name='tp_progress_settings[refresh_interval]'>";
    foreach ($intervals as $value => $label) {
        echo sprintf(
            '<option value="%d" %s>%s</option>',
            $value,
            selected($current_interval, $value, false),
            esc_html($label)
        );
    }
    echo "</select>";
}

function tp_show_changes_callback() {
    $options = get_option('tp_progress_settings', array());
    $checked = isset($options['show_changes']) ? $options['show_changes'] : true;
    
    echo "<input type='checkbox' id='show_changes' name='tp_progress_settings[show_changes]' " . 
         checked($checked, true, false) . " value='1'>";
    echo "<label for='show_changes'>" . esc_html(tp_get_text('show_changes_desc')) . "</label>";
}

function tp_debug_mode_callback() {
    $options = get_option('tp_progress_settings', array());
    $checked = isset($options['debug_mode']) ? $options['debug_mode'] : false;
    
    echo "<input type='checkbox' id='debug_mode' name='tp_progress_settings[debug_mode]' " . 
         checked($checked, true, false) . " value='1'>";
    echo "<label for='debug_mode'>" . esc_html(tp_get_text('debug_mode_desc')) . "</label>";
}

function tp_display_language_callback() {
    $options = get_option('tp_progress_settings', array());
    $current_language = isset($options['display_language']) ? 
        $options['display_language'] : 
        (get_locale() === 'zh_CN' ? 'zh_CN' : 'en_US');
    
    echo "<select id='display_language' name='tp_progress_settings[display_language]'>";
    echo "<option value='en_US' " . selected($current_language, 'en_US', false) . ">English</option>";
    echo "<option value='zh_CN' " . selected($current_language, 'zh_CN', false) . ">中文</option>";
    echo "</select>";
}

// 验证设置
function tp_validate_settings($input) {
    $output = array();
    
    // 获取现有选项
    $existing_options = get_option('tp_progress_settings', array(
        'refresh_interval' => 60,
        'show_changes' => true,
        'debug_mode' => false,
        'display_language' => get_locale() === 'zh_CN' ? 'zh_CN' : 'en_US'
    ));
    
    // 验证并保存刷新间隔
    $valid_intervals = array(60, 300, 600, 1800, 3600);
    $output['refresh_interval'] = isset($input['refresh_interval']) && 
        in_array((int)$input['refresh_interval'], $valid_intervals) ? 
        (int)$input['refresh_interval'] : $existing_options['refresh_interval'];
    
    // 验证并保存显示变化选项
    $output['show_changes'] = !empty($input['show_changes']);
    
    // 验证并保存调试模式选项
    $output['debug_mode'] = !empty($input['debug_mode']);
    
    // 验证并保存显示语言选项
    $valid_languages = array('en_US', 'zh_CN');
    $output['display_language'] = isset($input['display_language']) && 
        in_array($input['display_language'], $valid_languages) ? 
        $input['display_language'] : $existing_options['display_language'];
    
    return $output;
}

// 设置页面显示函数
function tp_progress_settings_page() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // 添加设置保存消息
    if (isset($_GET['settings-updated'])) {
        add_settings_error(
            'tp_progress_messages',
            'tp_progress_message',
            tp_get_text('settings_saved'),
            'updated'
        );
    }
    
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(tp_get_text('settings_title')); ?></h1>
        <?php settings_errors('tp_progress_messages'); ?>
        
        <form method="post" action="options.php">
            <?php
            settings_fields('tp_progress');
            do_settings_sections('tp_progress');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// 插件激活时的处理
register_activation_hook(__FILE__, 'tp_progress_activate');
function tp_progress_activate() {
    $default_settings = array(
        'refresh_interval' => 60,
        'show_changes' => true,
        'debug_mode' => false,
        'display_language' => get_locale() === 'zh_CN' ? 'zh_CN' : 'en_US'
    );
    
    // 只在选项不存在时添加默认值
    if (false === get_option('tp_progress_settings')) {
        add_option('tp_progress_settings', $default_settings);
    }
    
    if (false === get_option('tp_last_progress')) {
        add_option('tp_last_progress', array());
    }
}

// 添加插件卸载函数
register_uninstall_hook(__FILE__, 'tp_progress_uninstall');
function tp_progress_uninstall() {
    delete_option('tp_progress_settings');
    delete_option('tp_last_progress');
}

// 添加监控页面显示函数
function tp_progress_page() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // 获取 TranslatePress 设置
    $trp_settings = get_option('trp_settings', array());
    if (empty($trp_settings['translation-languages'])) {
        echo '<div class="wrap"><div class="notice notice-error"><p>' . 
             esc_html(tp_get_text('no_trp_settings')) . '</p></div></div>';
        return;
    }
    
    // 获取插件设置
    $options = get_option('tp_progress_settings');
    $show_debug = isset($options['debug_mode']) ? $options['debug_mode'] : false;
    
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(tp_get_text('translation_progress')); ?></h1>
        
        <!-- 自动刷新倒计时 - 移到顶部 -->
        <div class="refresh-info" style="background: #fff; padding: 15px 20px; margin: 20px 0; border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center;">
            <div>
                <?php echo sprintf(esc_html(tp_get_text('refresh_countdown')), 
                    isset($options['refresh_interval']) ? intval($options['refresh_interval']) : 60); ?>
            </div>
            <button type="button" class="button button-secondary" onclick="location.reload();">
                <?php echo esc_html(tp_get_text('refresh_now')); ?>
            </button>
        </div>
        
        <?php if ($show_debug): ?>
        <div class="debug-info" style="background: #f8f9fa; padding: 20px; margin: 20px 0; border-left: 4px solid #646970;">
            <h3 style="margin-top: 0;"><?php echo esc_html(tp_get_text('debug_info')); ?></h3>
            
            <!-- TranslatePress 设置检查 -->
            <div class="debug-section" style="margin-bottom: 20px;">
                <h4><?php echo esc_html(tp_get_text('trp_settings')); ?>:</h4>
                <table class="widefat striped" style="margin-top: 10px;">
                    <tbody>
                        <tr>
                            <td><strong><?php echo esc_html(tp_get_text('default_language')); ?></strong></td>
                            <td><?php echo esc_html(isset($trp_settings['default-language']) ? 
                                get_language_name($trp_settings['default-language']) : tp_get_text('not_set')); ?></td>
                        </tr>
                        <tr>
                            <td><strong><?php echo esc_html(tp_get_text('target_languages')); ?></strong></td>
                            <td><?php 
                                if (isset($trp_settings['translation-languages'])) {
                                    $languages = array_map('get_language_name', $trp_settings['translation-languages']);
                                    echo esc_html(implode(', ', $languages));
                                } else {
                                    echo esc_html(tp_get_text('not_set'));
                                }
                            ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- 数据库表检查 -->
            <div class="debug-section" style="margin-bottom: 20px;">
                <h4><?php echo esc_html(tp_get_text('database_check')); ?>:</h4>
                <table class="widefat striped" style="margin-top: 10px;">
                    <thead>
                        <tr>
                            <th><?php echo esc_html(tp_get_text('table_name')); ?></th>
                            <th><?php echo esc_html(tp_get_text('status')); ?></th>
                            <th><?php echo esc_html(tp_get_text('records')); ?></th>
                            <th><?php echo esc_html(tp_get_text('empty_translations')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    global $wpdb;
                    $default_lang = isset($trp_settings['default-language']) ? $trp_settings['default-language'] : 'en_US';
                    
                    foreach ($trp_settings['translation-languages'] as $target_lang) {
                        if ($target_lang === $default_lang) continue;
                        
                        // 使用与进度条相同的表名生成方式
                        $table_name = $wpdb->prefix . 'trp_dictionary_' . 
                                     str_replace('-', '_', esc_sql($default_lang)) . '_' . 
                                     str_replace('-', '_', esc_sql($target_lang));
                        
                        // 获取记录数（直接尝试查询，如果表不存在会返回错误）
                        $total_records = $wpdb->get_var("SELECT COUNT(*) FROM {$table_name}");
                        
                        if ($wpdb->last_error) {
                            // 表不存在或查询错误
                            echo "<tr>";
                            echo "<td>{$table_name}</td>";
                            echo "<td><span style='color: #dc3232;'>✗ " . esc_html(tp_get_text('table_not_exists')) . "</span></td>";
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                            echo "</tr>";
                            
                            if ($show_debug) {
                                echo "<tr>";
                                echo "<td colspan='4'><div style='color: #dc3232; padding: 5px;'>";
                                echo "Error: " . esc_html($wpdb->last_error) . "<br>";
                                echo "Query: " . esc_html($wpdb->last_query);
                                echo "</div></td>";
                                echo "</tr>";
                            }
                            continue;
                        }
                        
                        // 如果能执行到这里，说明表存在
                        $empty_translations = $wpdb->get_var("
                            SELECT COUNT(*) 
                            FROM {$table_name} 
                            WHERE translated = '' OR translated IS NULL
                        ");
                        
                        echo "<tr>";
                        echo "<td>{$table_name}</td>";
                        echo "<td><span style='color: #46b450;'>✓ " . esc_html(tp_get_text('table_exists')) . "</span></td>";
                        echo "<td>" . esc_html($total_records) . "</td>";
                        echo "<td>" . esc_html($empty_translations) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
                
                <?php if ($show_debug): ?>
                <!-- 数据库连接信息 -->
                <div style="margin-top: 15px; padding: 10px; background: #f0f0f1; border-left: 4px solid #646970;">
                    <h4 style="margin-top: 0;"><?php echo esc_html(tp_get_text('database_info')); ?>:</h4>
                    <ul style="margin: 0; padding-left: 20px;">
                        <li><?php echo esc_html(tp_get_text('db_name')); ?>: <?php echo esc_html(DB_NAME); ?></li>
                        <li><?php echo esc_html(tp_get_text('db_host')); ?>: <?php echo esc_html(DB_HOST); ?></li>
                        <li><?php echo esc_html(tp_get_text('table_prefix')); ?>: <?php echo esc_html($wpdb->prefix); ?></li>
                        <li><?php echo esc_html(tp_get_text('db_charset')); ?>: <?php echo esc_html($wpdb->charset); ?></li>
                        <li><?php echo esc_html(tp_get_text('db_collate')); ?>: <?php echo esc_html($wpdb->collate ?: 'Not set'); ?></li>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- WordPress 环境信息 -->
            <div class="debug-section" style="margin-bottom: 20px;">
                <h4><?php echo esc_html(tp_get_text('wp_environment')); ?>:</h4>
                <table class="widefat striped" style="margin-top: 10px;">
                    <tbody>
                        <tr>
                            <td><strong>WordPress</strong></td>
                            <td><?php echo esc_html($GLOBALS['wp_version']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>PHP</strong></td>
                            <td><?php echo esc_html(PHP_VERSION); ?></td>
                        </tr>
                        <tr>
                            <td><strong>MySQL</strong></td>
                            <td><?php echo esc_html($wpdb->db_version()); ?></td>
                        </tr>
                        <tr>
                            <td><strong><?php echo esc_html(tp_get_text('memory_usage')); ?></strong></td>
                            <td><?php 
                                $memory_usage = memory_get_usage();
                                echo esc_html(size_format($memory_usage));
                                echo ' / ';
                                echo esc_html(ini_get('memory_limit'));
                            ?></td>
                        </tr>
                        <tr>
                            <td><strong><?php echo esc_html(tp_get_text('max_execution_time')); ?></strong></td>
                            <td><?php echo esc_html(ini_get('max_execution_time')); ?>s</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- 插件设置信息 -->
            <div class="debug-section">
                <h4><?php echo esc_html(tp_get_text('current_settings')); ?>:</h4>
                <table class="widefat striped" style="margin-top: 10px;">
                    <tbody>
                        <tr>
                            <td><strong><?php echo esc_html(tp_get_text('refresh_interval')); ?></strong></td>
                            <td><?php echo isset($options['refresh_interval']) ? 
                                esc_html($options['refresh_interval'] . tp_get_text('seconds')) : 
                                esc_html(tp_get_text('not_set')); ?></td>
                        </tr>
                        <tr>
                            <td><strong><?php echo esc_html(tp_get_text('show_changes')); ?></strong></td>
                            <td><?php echo isset($options['show_changes']) && $options['show_changes'] ? 
                                esc_html(tp_get_text('enabled')) : 
                                esc_html(tp_get_text('disabled')); ?></td>
                        </tr>
                        <tr>
                            <td><strong><?php echo esc_html(tp_get_text('debug_mode')); ?></strong></td>
                            <td><?php echo isset($options['debug_mode']) && $options['debug_mode'] ? 
                                esc_html(tp_get_text('enabled')) : 
                                esc_html(tp_get_text('disabled')); ?></td>
                        </tr>
                        <tr>
                            <td><strong><?php echo esc_html(tp_get_text('display_language')); ?></strong></td>
                            <td><?php echo esc_html(get_language_name(
                                isset($options['display_language']) ? 
                                $options['display_language'] : 
                                (get_locale() === 'zh_CN' ? 'zh_CN' : 'en_US')
                            )); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- 翻译进度显示 -->
        <?php display_translation_progress($trp_settings); ?>
    </div>
    
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        var refreshInterval = <?php 
            echo isset($options['refresh_interval']) ? intval($options['refresh_interval']) : 60;
        ?>;
        var countdown = refreshInterval;
        
        function updateCountdown() {
            $('.refresh-info div').html('<?php echo esc_js(tp_get_text('refresh_countdown')); ?>'.replace('%d', countdown));
            if (countdown <= 0) {
                location.reload();
            }
            countdown--;
        }
        
        setInterval(updateCountdown, 1000);
    });
    </script>
    <?php
}

// 添加翻译进度显示函数
function display_translation_progress($settings) {
    global $wpdb;
    
    $options = get_option('tp_progress_settings');
    $show_changes = isset($options['show_changes']) ? $options['show_changes'] : true;
    $last_progress = get_option('tp_last_progress', array());
    $new_progress = array();
    $has_progress = false;
    
    $default_lang = isset($settings['default-language']) ? $settings['default-language'] : 'en_US';
    
    foreach ($settings['translation-languages'] as $target_lang) {
        if ($target_lang === $default_lang) continue;
        
        $table_name = $wpdb->prefix . 'trp_dictionary_' . 
                     str_replace('-', '_', esc_sql($default_lang)) . '_' . 
                     str_replace('-', '_', esc_sql($target_lang));
        
        // 获取翻译统计
        $total_count = $wpdb->get_var("SELECT COUNT(*) FROM {$table_name}");
        $translated_count = $wpdb->get_var("
            SELECT COUNT(*) 
            FROM {$table_name} 
            WHERE translated != '' 
            AND translated IS NOT NULL
        ");
        
        if ($wpdb->last_error) {
            echo '<div class="notice notice-error"><p>' . 
                 esc_html(tp_get_text('sql_error') . ': ' . $wpdb->last_error) . 
                 '</p></div>';
            continue;
        }
        
        if ($total_count > 0) {
            $has_progress = true;
            $percentage = round(($translated_count / $total_count) * 100, 2);
            
            // 保存当前进度用于比较
            $new_progress[$target_lang] = array(
                'percentage' => $percentage,
                'translated' => $translated_count,
                'total' => $total_count,
                'timestamp' => current_time('timestamp')
            );
            
            echo "<div class='progress-section' style='background: #fff; padding: 20px; margin: 20px 0; border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);'>";
            echo "<h2>" . sprintf(esc_html(tp_get_text('from_to')), 
                esc_html(get_language_name($default_lang)), 
                esc_html(get_language_name($target_lang))) . "</h2>";
            
            // 进度条显示
            echo "<div style='background-color: #f0f0f0; height: 20px; border-radius: 10px; overflow: hidden; margin: 10px 0;'>";
            echo "<div style='width: {$percentage}%; height: 100%; background-color: #2271b1; transition: width 0.3s ease;'></div>";
            echo "</div>";
            
            // 进度信息显示
            echo "<div style='display: flex; justify-content: space-between; margin: 10px 0;'>";
            echo "<div>" . esc_html(tp_get_text('current_progress')) . ": {$percentage}%</div>";
            echo "<div>" . esc_html(tp_get_text('translated_count')) . ": {$translated_count} / {$total_count}</div>";
            echo "</div>";
            
            // 显示与上次的比较
            if ($show_changes && isset($last_progress[$target_lang])) {
                $last = $last_progress[$target_lang];
                $diff_percentage = $percentage - $last['percentage'];
                $diff_translated = $translated_count - $last['translated'];
                $diff_total = $total_count - $last['total'];
                $time_diff = human_time_diff($last['timestamp'], current_time('timestamp'));
                
                echo "<div class='progress-comparison' style='margin-top: 10px; padding: 10px; background: #f8f9fa; border-radius: 5px;'>";
                echo "<p style='margin: 0;'>" . sprintf(esc_html(tp_get_text('compared_to_last')), $time_diff) . "</p>";
                
                if ($diff_total !== 0) {
                    $total_change_color = '#666666';
                    $total_sign = $diff_total > 0 ? '+' : '';
                    echo "<div style='color: {$total_change_color}; margin-bottom: 5px;'>";
                    echo esc_html(tp_get_text('total_content_change')) . ": {$total_sign}{$diff_total}";
                    echo "</div>";
                }
                
                $color = $diff_percentage >= 0 ? '#46b450' : '#dc3232';
                $sign = $diff_percentage >= 0 ? '+' : '';
                echo "<div style='color: {$color};'>";
                echo esc_html(tp_get_text('progress_change')) . ": {$sign}{$diff_percentage}% ";
                echo "({$sign}{$diff_translated})";
                echo "</div>";
                
                echo "<div style='margin-top: 5px; font-size: 0.9em; color: #666;'>";
                echo esc_html(tp_get_text('previous_stats')) . ": " . $last['translated'] . " / " . $last['total'] . "<br>";
                echo esc_html(tp_get_text('current_stats')) . ": " . $translated_count . " / " . $total_count;
                echo "</div>";
                
                echo "</div>";
            }
            
            echo "</div>";
        }
    }
    
    // 更新进度记录
    if (!empty($new_progress)) {
        update_option('tp_last_progress', $new_progress);
    }
    
    if (!$has_progress) {
        echo "<div class='notice notice-info'><p>" . esc_html(tp_get_text('no_progress_data')) . "</p></div>";
    }
}

// 获取语言名称函数
function get_language_name($code) {
    $options = get_option('tp_progress_settings');
    $language = isset($options['display_language']) ? 
        $options['display_language'] : 
        (get_locale() === 'zh_CN' ? 'zh_CN' : 'en_US');
    
    $languages = array(
        'zh_CN' => array(
            'en_US' => '英语(美国)',
            'zh_CN' => '简体中文',
            'zh_TW' => '繁体中文',
            'ja' => '日语',
            'ko_KR' => '韩语',
            'es_ES' => '西班牙语',
            'fr_FR' => '法语',
            'de_DE' => '德语',
            'it_IT' => '意大利语',
            'ru_RU' => '俄语',
            'pt_BR' => '葡萄牙语(巴西)',
            'pt_PT' => '葡萄牙语',
            'nl_NL' => '荷兰语',
            'pl_PL' => '波兰语',
            'tr_TR' => '土耳其语',
            'ar' => '阿拉伯语',
            'th' => '泰语',
            'vi' => '越南语',
            'id_ID' => '印尼语',
            'ms_MY' => '马来语',
            'hi_IN' => '印地语',
            'bn_BD' => '孟加拉语'
        ),
        'en_US' => array(
            'en_US' => 'English (US)',
            'zh_CN' => 'Simplified Chinese',
            'zh_TW' => 'Traditional Chinese',
            'ja' => 'Japanese',
            'ko_KR' => 'Korean',
            'es_ES' => 'Spanish',
            'fr_FR' => 'French',
            'de_DE' => 'German',
            'it_IT' => 'Italian',
            'ru_RU' => 'Russian',
            'pt_BR' => 'Portuguese (Brazil)',
            'pt_PT' => 'Portuguese',
            'nl_NL' => 'Dutch',
            'pl_PL' => 'Polish',
            'tr_TR' => 'Turkish',
            'ar' => 'Arabic',
            'th' => 'Thai',
            'vi' => 'Vietnamese',
            'id_ID' => 'Indonesian',
            'ms_MY' => 'Malay',
            'hi_IN' => 'Hindi',
            'bn_BD' => 'Bengali'
        )
    );
    
    // 如果找不到语言代码对应的名称，返回原始代码
    return isset($languages[$language][$code]) ? 
        $languages[$language][$code] : 
        (isset($languages['en_US'][$code]) ? $languages['en_US'][$code] : $code);
}

