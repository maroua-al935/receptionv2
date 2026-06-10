@extends('..President.layouts.master')
@section('body')
@php
    $url="visits;"
@endphp
<select name="test" id="test" x-data="{state: 'null'}" x-init="$watch('state', value => post_l(state))">
    <option @click="state = $el.value" value="1">a</option>
    <option @click="state = $el.value" value="2">b</option>
    <option @click="state = $el.value" value="3">c</option>
    <option @click="state = $el.value" value="4">d</option>
</select>
<script>
    function post_l(state) {
        fetch('http://localhost/profiles', {
            method: 'POST',
            body: JSON.stringify({state_out: state}),
            headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },
        })

}
</script>
@endsection
