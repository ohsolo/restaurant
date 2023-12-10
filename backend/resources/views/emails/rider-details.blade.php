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
          <td>Rider Name :  </td>
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
    <h1>Rider Request for Update Details</h1>
    <!-- <h2>You are just one step away</h2> -->
    
            <table border="0" cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td>Rider Name :  </td>
                  <td>{{$details->name}} </td>
                </tr>
               
                <tr>
                  <td>CPF : </td>
                  <td>{{$details->cpf}} </td>
                </tr>
                <tr>
                  <td>Phone Number : </td>
                  <td>{{$details->phone}} </td>
                </tr>
              </tbody>
            </table>
        
  </body>
</html>