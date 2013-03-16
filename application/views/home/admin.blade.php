@layout('layouts.master');

<?php
Section::append('page_title', 'Administrative Interface');
Section::start('content');
?>

<h1>Administrative Controls</h1>

<div class="row">
    <div class="span6">
        <h2>Users</h2>
        <ul class="user-list">
            <?php foreach($users as $user): ?>
            <li>
                <?php
                echo render('user.partials.link', array('user'=>$user));

                echo render('partials.label', array('content'=>$user->group()->first()->name));

                if($user->suspended) {
                    echo render('partials.label', array('content'=>'suspended', 'type'=>'important'));
                }

                echo render('partials.delete_button', array('location'=>'user/delete', 'id'=>$user->id, 'inline'=>true, 'class'=>'btn btn-mini btn-danger'));
                ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <div id="AddUserForm">
            <?php
            // Not using Formly because we want an inline form, and it doesn't play nicely with them
            echo Form::open('user/add', 'POST', array('class'=>'form-inline'));
            echo Form::text('crsid', null, array('placeholder'=>'crsid', 'class'=>'input-small'));
            echo Form::select('group', $groups_list, null, array('class'=>'input-medium'));
            echo Form::submit('add user', array('class'=>'btn btn-primary'));
            echo Form::close();
            ?>
        </div>
    </div>
    <div class="span6">
        <h2>Groups</h2>
        <ul>
            <?php foreach($groups as $group): ?>
            <li>
                <?php echo $group->name . ' (' . $group->user()->count() . ')'; ?>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
</div>
<hr/>

<?php Section::stop(); ?>