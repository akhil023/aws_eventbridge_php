<?php
// Load the AWS SDK
require 'vendor/autoload.php';

// composer.json - {"require": {"aws/aws-sdk-php": "^3.112"}}
use Aws\EventBridge\EventBridgeClient;

// Instantiate the EventBridge client 
$client = new EventBridgeClient([
    // 'credentials' => [
    //   'key' => '****',
    //   'secret' => '****',
    //   'session_token' => '****'
    // ],
    'region' => 'us-east-1',
    // Eventbridge version
    'version' => '2015-10-07' 
]);

// Event data
$event = [
    'ticket_id' => 12345,
    'companyId' => 255,
    'ticketNumber' => 9876,
    'customerName' => 'Adam Zampa',
    'primaryInfo' => '',
    'serviceType' => '',
    'serviceSubType' => '',
    'serviceStatus' => '',
    'ticketStatus' => 'Open',
    'addressLine1' => '',
    'addressLine2' => '',
    'addressLongitude' => '35.2218325',
    'addressLatitude' => '-80.8186606',
    'addressCityName' => '',
    'addressStateAbbr' => '',
    'addressPostalCode' => '',
    'subscriberId' => 5533
    // ...
];

// Set the event bus and detail type  
$params = [
    'Entries' => [
        [
            'Source' => 'MBS.App',
            'DetailType' => 'newTicketCreatedEventNotification',
            'Detail' => json_encode($event),
            'EventBusName' => 'default'
        ]
    ]
];

// Send the event  
$result = $client->putEvents($params);

// echo $result;
// Handle response
if (isset($result['FailedEntryCount']) && $result['FailedEntryCount'] > 0) {
    echo "Error submitting event\n";
    // TODO: run an api if putEvent to Eventbridge fails
} else {
    echo "Event submitted!\n";
}