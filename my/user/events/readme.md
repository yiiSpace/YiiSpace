参考
----------

[laravel events](http://laravel.com/docs/5.1/events)
~~~

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\PodcastWasPurchased' => [
            'App\Listeners\EmailPurchaseConfirmation',
        ],
    ];

~~~