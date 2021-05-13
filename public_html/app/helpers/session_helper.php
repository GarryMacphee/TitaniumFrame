<?php
session_start();

/**
 * See if the user is logged in by checking
 * the SESSION user_id value. If its set the
 * user is logged in
 * @return boolean true if Session user id
 * is set, false otherwise
 */
function isLoggedIn()
{
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}

/**
 * We are using the session name as the key and the message as the value
 * After the message has been displayed we unset the session values
 */
function flash($name = '', $message = '', $class = 'alert alert-success')
{
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {
            if (!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }

            if (!empty($_SESSION[$name . '_class'])) {
                unset($_SESSION[$name . '_class']);
            }

            //set the session name if doesn't exist
            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';

            echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';

            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}

/**
 * Remove a flash message from the screen
 * before the next page redirect
 * @param type $name ref of the message to remove
 */
function cancelFlash($name, $message)
{
    if (!empty($_SESSION[$name . '_class'])) {
        unset($_SESSION[$name . '_class']);
    }
    if (!empty($_SESSION[$name])) {
        unset($_SESSION[$name]);
    }
    if (!empty($_SESSION[$message])) {
        unset($_SESSION[$message]);
    }
}
