@include('emails.fragments.salutation', ['name' => $name])
@lang('view/experience/emails.content.common')
@lang('view/experience/emails.content.validated')<br/><br/>
@lang('view/experience/emails.content.visibility')<br/><br/><br/>
@lang('fragment/emails/courtesy.common.valediction.farewell')<br/><br/>
@include('emails.fragments.signature')