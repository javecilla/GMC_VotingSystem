@extends('errors/layout')

@section('title', __('429 TOO MANY REQUESTS'))
@section('code', '429')
@section('header', __('Too Many Requests'))
@section('message', __('You have exceeded the allowed number of requests. Please try again later or contact the administrator.'))
