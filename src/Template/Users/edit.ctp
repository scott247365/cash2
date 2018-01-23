<?php //dump($user);die; ?>
<div class="form-style-11 users form large-9 medium-8 columns content">
    <?= $this->Form->create($user, ['class' => '']) ?>
    <fieldset>
        <legend><span class="glyphicon glyphicon-user"></span><?= __(' Update Your Account Info') ?></legend>
        <?php
            echo $this->Form->input('userName', ['label' => 'User Name:']);
            echo $this->Form->input('firstName', ['label' => 'First Name:']);
            echo $this->Form->input('lastName', ['label' => 'Last Name:']);
            echo $this->Form->input('passwordAuth', ['type' => 'password', 'label' => 'Enter your password to authorize this update:']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Update Info')) ?>
	<?= $this->Form->button(__('Cancel'), ['type' => 'button', 'onclick' => 'location.href=\'/\'']); ?>
	<?= $this->Form->input('update', ['type' => 'hidden', 'value' => 'info']); ?><!-- hidden field to id which form is being submitted -->
    <?= $this->Form->end() ?>
</div>

<div class="form-style-11 users form large-9 medium-8 columns content">
    <?= $this->Form->create($user, ['class' => '']) ?>
    <fieldset>
        <legend><span class="glyphicon glyphicon-envelope"></span><?= __(' Update Email') ?></legend>
        <?= $this->Form->input('email', ['label' => 'Email:', 'class' => 'marginBottom0']); ?>
		<?php if (!empty($user['key_verify_email'])) : ?>
			<div class="notVerified"><span class="glyphicon glyphicon-remove-circle"></span>&nbsp;Email Not Verified</div>
		<?php else : ?>
			<i><div class="inputHelpLine">(Requires Verification)</div></i>
		<?php endif; ?>
        <?= $this->Form->input('passwordAuth', ['type' => 'password', 'label' => 'Enter your password to authorize this update:']); ?>
    </fieldset>
    <?= $this->Form->button(__('Update Email')) ?>
	<?= $this->Form->button(__('Cancel'), ['type' => 'button', 'onclick' => 'location.href=\'/\'']); ?>
	<?= $this->Form->input('update', ['type' => 'hidden', 'value' => 'email']); ?><!-- hidden field to id which form is being submitted -->
    <?= $this->Form->end() ?>
</div>

<div class="form-style-11 users form large-9 medium-8 columns content">
    <?= $this->Form->create($user, ['class' => '']) ?>
    <fieldset>
        <legend><span class="glyphicon glyphicon-lock"></span><?= __(' Update Password') ?></legend>
        <?php
            echo $this->Form->input('passwordAuth', ['type' => 'password', 'label' => 'Current Password:']);
            echo $this->Form->input('passwordNew', ['type' => 'password', 'label' => 'New Password:']);
            echo $this->Form->input('passwordNew2', ['type' => 'password', 'label' => 'Repeat New Password:']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Update Password')) ?>
	<?= $this->Form->button(__('Cancel'), ['type' => 'button', 'onclick' => 'location.href=\'/\'']); ?>
	<?= $this->Form->input('update', ['type' => 'hidden', 'value' => 'password']); ?><!-- hidden field to id which form is being submitted -->
    <?= $this->Form->end() ?>
</div>
