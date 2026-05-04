<?php

namespace Uzzairwebstudio\Onewaysms {
    // Override file_get_contents in the package namespace to mock HTTP calls
    function file_get_contents($url) {
        global $mockResponses;
        return $mockResponses[$url] ?? '';
    }
}

namespace Tests\Feature {
    use Uzzairwebstudio\Onewaysms\OneWaySMSManager;

    beforeEach(function () {
        $this->manager = new OneWaySMSManager(
            'user',
            'pass',
            'http://mt',
            'http://status',
            'http://credit'
        );
    });

    test('can send sms', function () {
        global $mockResponses;
        $mockResponses['http://mt?apiusername=user&apipassword=pass&mobileno=60121234567&senderid=INFO&languagetype=1&message=Test'] = '200806150001';

        $result = $this->manager->send('60121234567', 'Test');
        
        expect($result)->toBe('200806150001');
    });

    test('can check status', function () {
        global $mockResponses;
        $mockResponses['http://status?mtid=200806150001'] = '0';

        $result = $this->manager->checkStatus('200806150001');
        
        expect($result)->toBe('0');
    });

    test('can check credit', function () {
        global $mockResponses;
        $mockResponses['http://credit?apiusername=user&apipassword=pass'] = '500';

        $result = $this->manager->checkCredit();
        
        expect($result)->toBe('500');
    });
}
