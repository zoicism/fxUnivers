<!DOCTYPE html>

<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices. -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
  <script src="https://www.paypal.com/sdk/js?client-id=AamVi8YxFRCNHDKC8cNfMuhM7IoNwGFbx59cMUQrd-Wd6d53EjjhhHJoWtCQeIXXxIIUCTfY6iVZ1gRQ"></script>
</head>

<body>

  <form>
    <input type="text" id="fxCoinAmnt">
  </form>

  <div id="paypal-button-container"></div>


<script>
  paypal.Buttons({
    createOrder: function(data, actions) {
    var amntTxt = document.getElementById("fxCoinAmnt").value;
    var amntToBase10 = parseInt(amntTxt, 10);
    var amnt = amntToBase10.toString();
      return actions.order.create({
        purchase_units: [{
          amount: {
	    
            value: amnt
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      return actions.order.capture().then(function(details) {
        alert('Transaction completed by ' + details.payer.name.given_name);
        // Call your server to save the transaction
        return fetch('/paypal-transaction-complete', {
          method: 'post',
          headers: {
            'content-type': 'application/json'
          },
          body: JSON.stringify({
            orderID: data.orderID
          })
        });
      });
    }
  }).render('#paypal-button-container');
</script>
</body>
</html>