<div>
<select name="service" id="service" wire:model="choice">
<option value="">select service</option>
@foreach ($services as $service)
    <option value="{{$service['id']}}">{{ $service['name']}}</option>
@endforeach
</select>
<input type="text" placeholder="{{$choice}}">
</div>
