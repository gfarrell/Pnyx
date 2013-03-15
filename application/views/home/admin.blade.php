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

        <div class="well">
            <h3><a href="#AddUserForm" data-toggle="collapse" data-target="#AddUserForm">New User</a></h3>
            <div id="AddUserForm" class="collapse out">
                <?php
                $uForm = Formly::make('User');
                echo $uForm->open('user/add');
                echo $uForm->text('crsid', 'CRSID', null, array('placeholder'=>'crsid'));
                echo $uForm->select('group', 'Group', $groups_list);
                echo $uForm->submit_primary('add user');
                echo $uForm->close();
                ?>
            </div>
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