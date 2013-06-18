@layout('layouts.master')

<?php
    Section::append('page_title', 'Edit User');
?>

@section('content')
    <?php $form = Formly::make($user)->set_options(array('display-inline-errors'=>true)); ?>
    
    {{ $form->open('user/edit/'.$user->id, 'PUT') }}
    {{ $form->hidden('id') }}
    
    <fieldset class="row">
        <legend>User groups for {{ $user->crsid }}</legend>
        
        <div class="span4 muted">
            <p>A user can belong to any number of groups, and you can select which ones <b>{{ $user->crsid }}</b> belongs to here.</p>
        </div>
        <div class="span8">
            @foreach($groups as $group)
                {{ $form->checkbox('user.groups', $group->name, $group->id, $user->inGroup($group->name)) }}
            @endforeach
        </div>
    </fieldset>

    <div class="form-actions">
        {{ $form->submit_primary('Save') }}
        <button class="btn btn-danger" type="reset">Cancel</button>
    </div>
    {{ $form->close() }}
@endsection