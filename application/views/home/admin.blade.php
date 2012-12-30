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
                ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php
        $uForm = Formly::make('User');
        echo $uForm->open('user/add');
        echo $uForm->text('crsid', null, array('placeholder'=>'crsid'));
        echo $uForm->select('group', $groups);
        echo $uForm->submit('add user');
        echo $uForm->close();
        ?>
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