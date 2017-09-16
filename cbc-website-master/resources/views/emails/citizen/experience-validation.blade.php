@include('emails.fragments.salutation', ['name' => $name])
@lang('view/experience/emails.content.common')
@lang('view/experience/emails.content.validation')<br/><br/>
@lang('fragment/emails/courtesy.common.valediction.experience')<br/><br/>
@include('emails.fragments.farewell')