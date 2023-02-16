<?php
require_once 'vendor/autoload.php';
use Zendesk\API\HttpClient as ZendeskAPI;

// Set your Zendesk subdomain and API token
$subdomain = 'southerngreeninc';
$user  = 'rob@ssss.com';
$token = 'sssss';
global $api_key;
$api_key = 'zzz ';
global $fields;
$fields = array('subject', 'body', 'requester_id', 'assignee_id', 'group_id', 'tags', 'priority', 'status', 'collaborator_ids');

global $client;
$client = new ZendeskAPI($subdomain);
$client->setAuth('basic', ['username' => $user, 'token' => $token]);