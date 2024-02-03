@extends('errors/layout')

@section('title', __('500 INTERNAL SERVER ERROR'))
@section('code', '500')
@section('header', __('Internal Server Error'))
@section('message', __('An error occurred on the server. Please try again later or contact the administrator.'))
