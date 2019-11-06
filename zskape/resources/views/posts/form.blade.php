
<div>
    <div style="float:left;" id="characters-count"> </div> <br/>
        {!! Form::text('title', null, ['class' => 'form-comment-post create-post', 'id' => 'form-character-limit', 'required', 'placeholder' => 'Title', ]) !!}
    </div>

    <div>
        {!! Form::submit($submitButton, ['class' => 'btn btn-primary form-control special-btn', 'style' => 'font-size:17px; width:100px; margin-top:5px']) !!}
    </div>
