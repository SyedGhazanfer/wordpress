<?php

/**
 * Plugin Name: userNotifications
 * Plugin URI: https://www.your-site.com/
 * Description: Test Firbase Notification for User.
 * Version: 0.1
 * Author: Noroz Hyder
 * Author URI: https://www.your-site.com/
 **/
function push_notification_enqueue_scripts()
{
  // Enqueue Firebase scripts from the 'fcm' directory
  wp_enqueue_script('firebase-app', plugin_dir_url(__FILE__) . 'firebase-app.js');
  wp_enqueue_script('firebase-messaging', plugin_dir_url(__FILE__) . 'firebase-messaging.js');

  // print_r(plugin_dir_url(__FILE__));
  // die;
}

add_action('wp_enqueue_scripts', 'push_notification_enqueue_scripts');
function push_notification_form_shortcode()
{
  ob_start();
?>
  <script>
    async function getDeviceToken() {

      // Initialize the Firebase app
      firebase.initializeApp({
        apiKey: "AIzaSyDMNsFJ_RL-5VKyf5gI4i39t0C6XxDtb6U",
        authDomain: "notify-af41d.firebaseapp.com",
        projectId: "notify-af41d",
        storageBucket: "notify-af41d.appspot.com",
        messagingSenderId: "1029184910754",
        appId: "1:1029184910754:web:6160468ce0ab4823056efb",
        measurementId: "G-JQWZW1ZVT7"
      });


      // Get the device token
      const token = await firebase.messaging().getToken();
      console.log(1)

      console.log(token);

      return token;
    }

    function base64UrlEncode(base64) {
      return base64.replace(/=/g, '').replace(/\+/g, '-').replace(/\//g, '_');
    }

    getDeviceToken().then((token) => {
      (function($) {
        $.ajax({
          url: 'https://mirhasoft.com/notify/save_token.php', // AJAX endpoint provided by WordPress
          type: 'POST',
          data: {
            action: 'save_device_token',
            host: window.location.href,
            device_token: token
          },
          success: function(response) {
            console.log('Device token saved successfully:', token);
          },
          error: function(error) {
            console.error('Error saving device token:', error);
          }
        });
      })(jQuery);

    });
  </script>
<?php
  return ob_get_clean();
}

add_shortcode('push_notification_form', 'push_notification_form_shortcode');
