@extends('errors/layout')

@section('title', __('401 UNAUTHORIZED'))
@section('code', '401')
@section('header', __('Unauthorized Access'))
@section('message', __('You are not authorized to access this resource. Please log in or contact the administrator if you believe this is an error.'))
