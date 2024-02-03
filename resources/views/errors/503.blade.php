@extends('errors/layout')

@section('title', __('503 SERVICE UNAVAILABLE'))
@section('code', '503')
@section('header', __('Service Unavailable'))
@section('message', __('The service is currently unavailable. Please try again later or contact the administrator.'))
