<?php 
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
 */
require_once(__DIR__ . '/../../../../config.php');
require_login();

global $PAGE, $DB, $SESSION;

$userid = $SESSION->userid;
$quizid = $SESSION->quizid;

$attemptid = required_param('attemptid', PARAM_INT);
$cmid      = required_param('cmid', PARAM_INT);
$page      = required_param('page', PARAM_INT);
?>
<html>
    <head>
        <title>E-Procotring check</title>
    </head>

    <body>
    <?php 
        $session_details = \quizaccess_edusynch\session::create($userid, $quizid);

        // Student session
        if($session_details['success']):
            $SESSION->edusynch_started   = true;        
            $SESSION->edusynch_sessionid = $session_details['session_id'];        
            $SESSION->edusynch_token     = $session_details['token'];        
            $start_event = \quizaccess_edusynch\session::create_event_for($session_details['token'], $session_details['session_id'], 'START_SIMULATION');
        ?>    
        <form action="<?php echo "$CFG->wwwroot/$SESSION->edusynch_redirect" ?>" data-proctoring="form" method="GET">
            <input type="hidden" name="attempt" value="<?php echo $attemptid ?>">
            <input type="hidden" name="cmid" value="<?php echo $cmid ?>">
            <input type="hidden" name="page" value="<?php echo $page ?>">
            <button data-proctoring="start" data-id="<?php echo $session_details['session_id'] ?>" data-token="<?php echo $session_details['token'] ?>" type="submit" style="display: none"></button>
        </form>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>   
        <script type="text/javascript">
            setTimeout(function() {
                $('button').trigger('click');
            }, 1000);    
        </script>        
    <?php endif; ?>
    </body>
</html>
