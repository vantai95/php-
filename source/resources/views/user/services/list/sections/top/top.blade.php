<div class="service-top">
  @foreach($section->data as $data)
    @include($data->client_template,['data' => $data])
  @endforeach
</div>
