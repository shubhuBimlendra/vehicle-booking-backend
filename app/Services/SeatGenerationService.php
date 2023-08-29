<?php
namespace App\Services;
use App\Enums\VehicleType;

class SeatGenerationService
{
    public function generateSeats($vehicleType)
    {
        if ($vehicleType === VehicleType::BUS) {
            return $this->generateBusSeats();
        } elseif ($vehicleType === VehicleType::MICRO) {
            return $this->generateMicroSeats();
        } else {
            return [];
        }
    }

    private function generateBusSeats()
    {
        $layout = [];
        $rows = 10;
        $columns = 4;

        for ($row = 1; $row <= $rows; $row++) {
            $rowLayout = [];
            $columns = ($row === 10) ? 5 : 4; // The last row has 5 columns, others have 4 columns
            for ($column = 1; $column <= $columns; $column++) {
                $seatType = $this->getSeatType($row, $column, $rows, $columns);
                $rowLayout[] = [
                    'row' => $row,
                    'column' => $column,
                    'status' => 'available',
                    'type' => $seatType,
                ];
            }
            $layout[] = $rowLayout;
        }

        return $layout;
    }


    private function getSeatType($row, $column, $totalRows, $totalColumns)
    {
        if ($row === 1) {
            return 'window';
        } elseif ($row === $totalRows) {
            return 'aisle';
        } elseif ($column === 1) {
            return 'aisle';
        } elseif ($column === $totalColumns) {
            return 'aisle';
        } else {
            return 'normal';
        }
    }

    private function generateMicroSeats()
    {
        $layout = [];

        for ($row = 1; $row <= 3; $row++) {
            $rowLayout = [];
            $columns = ($row === 3) ? 4 : 3; // The last row has 4 columns, others have 3 columns
            for ($column = 1; $column <= $columns; $column++) {
                $rowLayout[] = [
                    'row' => $row,
                    'column' => $column,
                    'status' => 'available',
                    'type' => 'normal',
                ];
            }
            $layout[] = $rowLayout;
        }
        return $layout;
    }


}


?>
