@extends('errors/layout')

@section('title', __('403 FORBIDDEN'))
@section('code', '403')
@section('header', __('Access Forbidden'))
@section('message', __('You do not have permission to access this resource. Please contact the administrator if you believe this is an error.' . $exception->getMessage() ?: 'Forbidden'))

