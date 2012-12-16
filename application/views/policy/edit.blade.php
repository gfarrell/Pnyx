@layout('layouts.master')

<?php
    $edit = isset($policy);
    $title = ($edit ? 'Edit ' : 'New ') . ' Policy Document';

    Section::append('page_title', $title);
?>


<?php Section::start('content'); ?>
    <h1><?php echo $title; ?></h1>
    
    <?php
        $form = Formly::make(($edit ? $policy : null))->set_options(array('display-inline-errors'=>true));

        if($edit) {
            echo $form->open('policy/edit', 'PUT');
            echo $form->hidden('id');
        } else {
            echo $form->open('policy/add', 'POST');
        }
    ?>
    
    <fieldset class="row">
        <legend>Basic details</legend>
        <div class="span4 muted">
            <p>
                All motions need a title, and it needs to be <em>unique</em>, for example <strong>Formal Motion III</strong>.
            </p>
            <p>
                The date of the Open Meeting during which the motion was tabled.
            </p>
            <p>
                The Proposer and Seconder of the motion. This should be their CRSIDs (e.g. <strong>gtf21</strong>, or, if that information is no longer available, their names, e.g. <strong>G.T. Farrell</strong>).
            </p>
        </div>
        <div class="span8">
            <?php
                echo $form->text('title', 'Title');
                echo $form->text('date', 'Date', null, array('placeholder'=>'dd-mm-yyyy'));
                echo $form->text('proposed', 'Proposed By');
                echo $form->text('seconded', 'Seconded By');
            ?>
        </div>
    </fieldset>
    
    <fieldset class="row">
        <legend>Motion Details</legend>
        
        <div class="span4 muted">
            <p>
                The details of the motion should be written in <?php echo HTML::link('http://www.daringfireball.com/projects/markdown', 'Markdown', array('target'=>'_blank')); ?>. This means that numbered points should be formatted as follows:
            </p>
            <pre class="code">
1. Point number one.
2. A point with subpoints
    1. A cool subpoint
    2. And another
3. And back to normal.</pre>
            <p>
                Normal lists use asterisks instead:
            </p>
            <pre class="code">
* A point.
* And another one!</pre>
            <p>
                Text can be <em>emphasised</em> using asterisks, for example: <code class="code">*emphasised text*</code>. To make it <strong>bold</strong> with double asterisks, like so: <code class="code">**bold text**</code>.
            </p>
        </div>
        <div class="span8">
            <?php
                echo $form->textarea('notes', 'KCSU Notes');
                echo $form->textarea('believes', 'KCSU Believes');
                echo $form->textarea('resolves', 'KCSU Resolves');
            ?>
        </div>
    </fieldset>
    
    <fieldset class="row">
        <legend>Vote</legend>
        
        <div class="span4 muted">
            <p>
                Here we record the details of the vote. If numbers were taken, please enter the numbers into the <strong>For</strong>, <strong>Against</strong> and <strong>Abstain</strong> boxes on the right. If only majority/minority votes were recorded, then use <strong>the letter m</strong> <em>majority</em> (case insensitive).
            </p>
        </div>
        <div class="span8">
            <div class="controls  input-append input-prepend">
                <span class="add-on"><i class="icon-thumbs-up"></i></span><!--
                --><?php echo Form::text('votes_for', null, array('size'=>'3', 'class'=>'input-mini', 'placeholder'=>'FOR')); ?><!--
                --><span class="add-on"><i class="icon-thumbs-down"></i></span><!--
                --><?php echo Form::text('votes_against', null, array('size'=>'3', 'class'=>'input-mini', 'placeholder'=>'AGAINST')); ?><!--
                --><span class="add-on"><i class="icon-check-empty"></i></span><!--
                --><?php echo Form::text('votes_abstain', null, array('size'=>'3', 'class'=>'input-mini', 'placeholder'=>'ABSTAIN')); ?>
            </div>
        </div>
    </fieldset>
    
    <fieldset class="row">
        <legend>Metadata</legend>
        
        <div class="span4 muted">
            <p>
                The metadata described here will help us keep our records in order, and enable better searching.
            </p>
            <p>
                The comma separated tags should be for related subject matter, e.g. &ldquo;formals&rdquo; or &ldquo;direct action&rdquo;. There will be automatically provided suggestions as you type.
            </p>
            <p>
                If this Policy should be reviewed when it is due to expire (i.e. in order to renew it) or at any other time (for example if the motion stipulates its own timeframe), then tick the review flag.
            </p>
        </div>
        <div class="span8">
            <?php
                echo $form->text('tags', 'Tags (comma separated)', null, array('class'=>'input-block-level'));
                echo $form->checkbox('review_flag', 'Flag for Review');
            ?>
        </div>
    </fieldset>
    
    <div class="form-actions">
        <?php echo $form->submit_primary('Save'); ?>
        <button class="btn btn-danger" type="reset">Cancel</button>
    </div>
    <?php echo $form->close(); ?>
<?php Section::stop(); ?>

<?php Section::start('scripts'); ?>
<script language="javascript" type="text/javascript">
    require(['lib/jquery/plugins/tagsinput'], function() {
        $('#field_tags').tagsInput({
            autocomplete_url: '/tags.json/{query}',
            autocomplete: {property: 'name'}
        });
    });
</script>
<?php Section::stop(); ?>