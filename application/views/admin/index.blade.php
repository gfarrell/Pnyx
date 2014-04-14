@layout('layouts.master');

<?php
Section::append('page_title', 'Administrative Interface');
?>

@section('content')

<h1>Administrative Controls</h1>

<div class="row">
    <div class="span6">
        <h2>Users</h2>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>crsid</th>
                    <th>groups</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>@render('user.partials.mailto', array('user'=>$user, 'label'=>$user->crsid))</td>
                    <td>
                        @foreach($user->groups()->get() as $ugrp)
                            @render('partials.label', array('content'=>$ugrp->name))
                        @endforeach
                    </td>
                    <td>
                        {{ HTML::link('/users/edit/'.$user->id, 'edit', array('class'=>'btn btn-mini')) }}
                        @render('partials.delete_button', array('location'=>'user/delete', 'id'=>$user->id, 'inline'=>true, 'class'=>'btn btn-mini btn-danger'))
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td colspan="4">
                        {{-- Not using Formly because we want an inline form, and it doesn't play nicely with them --}}
                        {{ Form::open('user/add', 'POST', array('class'=>'form-inline')); }}
                        <div class="control-group input-append">
                            {{ Form::text('crsid', null, array('placeholder'=>'crsid')); }}
                            <button class="btn btn-primary"><i class="icon-plus"></i></span>
                        </div>
                        {{ Form::close(); }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="span6">
        <h2>Groups</h2>
        <ul>
            @foreach($groups as $group)
            <li>
                {{ $group->name . ' (' . $group->users()->count() . ')' }}
            </li>
            @endforeach
        </ul>
    </div>
</div>
<hr/>

@endsection