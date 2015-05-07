<?php
/**
 * Created by PhpStorm.
 * User: tomasz
 * Date: 25.04.15
 * Time: 11:37
 *
 *
 */

  $orders = $user->getAllOrders();
  $out = "<table>";
  $out .= "<tr class='first-table-row'>";
  $out .= "<th>Date</th><th>Reference</th><th>State</th><th>Payment</th><th>Total</th>";
  $out .= "</tr>";

  foreach($orders as $ord){
      $out .= "<tr>";
      $out .= "<td>" . $ord->getDate() . "</td>";
      $out .= "<td>" . $ord->getID() . "</td>";
      $out .= "<td>" . $ord->getStatusToStr() . "</td>";
      $out .= "<td>" . isPaidFeedback($ord). "</td>";
      $out .= "<td> ___ </td>";
      $out .= "</tr>";
  }

  $out .= "</table>";
    echo $out;

    function isPaidFeedback($order){
        if($order->getStatus() == 1) { //only confirmed
            return "<button class='submit-btn-update'>Pay</button>";
        }

        return "Paid!";
    }

?>