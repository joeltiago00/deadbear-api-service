<?php

return [
    //Repositories
    App\Repositories\Address\AddressRepository::class => App\Repositories\Address\AddressEloquentRepository::class,
    App\Repositories\AddressType\AddressTypeRepository::class => App\Repositories\AddressType\AddressTypeEloquentRepository::class,
    App\Repositories\Card\CardRepository::class => App\Repositories\Card\CardEloquentRepository::class,
    App\Repositories\Client\ClientRepository::class => App\Repositories\Client\ClientEloquentRepository::class,
    App\Repositories\Costumer\CustomerRepository::class => App\Repositories\Costumer\CustomerEloquentRepository::class,
    App\Repositories\Item\ItemRepository::class => App\Repositories\Item\ItemEloquentRepository::class,
    App\Repositories\Purchase\PurchaseRepository::class => App\Repositories\Purchase\PurchaseEloquentRepository::class,
    App\Repositories\PurchaseItem\PurchaseItemRepository::class => App\Repositories\PurchaseItem\PurchaseItemEloquentRepository::class,
    App\Repositories\Transaction\TransactionRepository::class => App\Repositories\Transaction\TransactionEloquentRepository::class,
];
