@if($section->data->count() !== 0)
<div class="col-lg-12 feature">
  <button class="feature__name" type="button" data-toggle="collapse" data-target="#section{{$section->id}}" name="button" aria-expanded="true">{{$section->name}}</button>
  <div class="feature__detail collapse" id="section{{$section->id}}" aria-expanded="true">
    @foreach($section->data as $data)
      @php
       $dataTemplate = "admin.theme.template.{$data->template}";
      @endphp
      @if(\View::exists($dataTemplate))
        <div class="section__data">
          @include($dataTemplate,['sectionData' => $data,'images' => $images])
        </div>
      @endif
    @endforeach
  </div>
</div>
@endif
