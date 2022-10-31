<?php

namespace App\Service;


class SortPlayersThrowOrderService
{

    public function returnSortedPlayersThrowOrder(array $orderFormData): array
    {
        $orderData = [];
        foreach ($orderFormData as $playerId => $orderNumber){
            $orderData[] = ['playerId' => $playerId,
                'playerOrder' => $orderNumber];
        }
        array_multisort( array_column($orderData, 'playerOrder'), SORT_ASC, array_column($orderData ,'playerId'), SORT_ASC, $orderData);

        $sortedOrder = [];
        foreach ($orderData as $position => $playerData){
            $sortedOrder[$position] = $playerData['playerId'];
        }
        return $sortedOrder;
    }

}