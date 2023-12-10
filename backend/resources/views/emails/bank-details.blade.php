<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Simple Transactional Email</title>
 
  </head>
  <body class="">
    <h1>Rider Details</h1>
    <table border="0" cellpadding="0" cellspacing="0">
      <tbody>
        <tr>
          <td>Rider Name  : </td>
          <td>{{request()->rider->name}} </td>
        </tr>
        <tr>
          <td> Rider Number : </td>
          <td>{{request()->rider->phone}} </td>
        </tr>
        <tr>
          <td> Rider Email : </td>
          <td>{{request()->rider->email}} </td>
        </tr>
      </tbody>
    </table>
    <h1>Bank Details</h1>
    <!-- <h2>You are just one step away</h2> -->
 
            <table border="0" cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td>Bank  : </td>
                  <td>{{$details->Bank}} </td>
                </tr>
                <tr>
                  <td>Account Number : </td>
                  <td>{{$details->account}} </td>
                </tr>
                <tr>
                  <td>Agency : </td>
                  <td>{{$details->agency}} </td>
                </tr>
                <tr>
                  <td>Digit (Account verification code) : </td>
                  <td>{{$details->verification_code}} </td>
                </tr>
              </tbody>
            </table>
         

  </body>
</html>