## Junction X Seoul 'CADIT' Server
Hello, we're "Idiot Brothers" team.
<br>
We developed a service called CADIT (Cash + Deposit).
<br>
‘CADIT’ is a service that automatically saves a percentage of the amount you spend on your daily life.
<br>
### The Rakuten API was used as follows:
- [Nexmo SMS Messaging](https://english.api.rakuten.net/nexmo/api/nexmo-sms-messaging)
    - Register Phone Number `Verify` Message.
- [Web Search](https://english.api.rakuten.net/contextualwebsearch/api/web-search)
    - Entering a title in my goal setting will automatically match the `image`.
- [HTML To PDF](https://english.api.rakuten.net/restpack/api/html-to-pdf-conversionf)
    - Prints out the items that you purchased from the Dashboard to `PDF`.
- [Noodlio Pay - Smooth Payments with Stripe](https://english.api.rakuten.net/noodlio/api/noodlio-pay-smooth-payments-with-stripe)
    - `Validation` is carried out when the user registers the card.

### Other API:
- Korea Finacial Telecommuniations & Clearings Insitute API
    - Account real name check
    - Transaction details check
    - Deposit / Withdrawal transfer

### Server Architecture
- AWS EC2 (production)

### Server Stack
- Laravel (PHP Framework)
- MySQL

## Swagger API Documentation
<br>
<img src="https://raw.githubusercontent.com/cadit/laravel-cadit/master/swagger.png" width="500" height="500 />


