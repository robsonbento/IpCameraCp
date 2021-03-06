<?php
require_once(dirname(dirname(dirname(__DIR__))) . "/Classes/System/Root.php");

if (isset($_SESSION['userLogged']) == false)
    return;

$root = new Root();

$id = isset($_SESSION['userManagement']['id']) == true ? $_SESSION['userManagement']['id'] : 0;

$userRow = $root->getUtility()->getQuery()->selectUserDatabase($id);
?>
<form id="form_user_management" class="margin_top" action="<?php echo $root->getUtility()->getUrlRoot() ?>/Requests/IpCameraRequest.php?controller=userManagementProfileAction" method="post" novalidate="novalidate">
    <div id="user_management_roleUserId_wordTag_container" class="form-group">
        <label class="control-label required" for="form_user_management_roleUserId">Role</label>
        <input id="form_user_management_roleUserId" class="form-control" type="hidden" name="form_user_management[roleUserId]" value="<?php echo $userRow['role_user_id']; ?>" required="required">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-tags"></i></span>
            <?php echo $root->getUtility()->createUserRoleHtml("form_user_management_roleUserId_field", true); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label required" for="form_user_management_username">Username</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-paw"></i></span>
            <input id="form_user_management_username" class="form-control" type="text" name="form_user_management[username]" value="<?php echo $userRow['username']; ?>" required="required"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label required" for="form_user_management_email">Email</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
            <input id="form_user_management_email" class="form-control" type="text" name="form_user_management[email]" value="<?php echo $userRow['email']; ?>" required="required"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label required" for="form_user_management_password">Password</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-key"></i></span>
            <input id="form_user_management_password" class="form-control" type="password" name="form_user_management[password]" value="" required="required"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label required" for="form_user_management_passwordConfirm">Password confirm</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-key"></i></span>
            <input id="form_user_management_passwordConfirm" class="form-control" type="password" name="form_user_management[passwordConfirm]" value="" required="required"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label required" for="form_user_management_notLocked">Not locked</label>
        <select id="form_user_management_notLocked" class="form-control" name="form_user_management[notLocked]">
            <?php
            $elements = Array('No' => 0, 'Yes' => 1);
            $options = "";

            foreach($elements as $key => $value) {
                $selected = $userRow['not_locked'] == $value ? "selected=\"selected\"" : "";

                $options .= "<option $selected value=\"$value\">$key</option>";
            }

            echo $options;
            ?>
        </select>
    </div>
    
    <input id="form_user_management_token" class="form-control" type="hidden" name="form_user_management[token]" value="<?php echo $_SESSION['token']; ?>"/>
    <input class="button_custom" type="submit" value="Send"/>
</form>