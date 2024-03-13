<x-mail::message>
  <p>{{ __('Dear,') }} <b>{{ $data['name'] }}</b>,</p><br/>

  {{-- Admin's reply message --}}
  <p>{{ $data['replyMessage'] }}</p>

  <br>
  <p>
  	{{ __("Best regards,") }} <br>
    <b>{{ __("Voting System - Admin") }}</b>
  </p>
</x-mail::message>
