<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once("conexion.php");
    require("fpdf/fpdf.php");


    // Buscar último cierre

    $sql = "
    SELECT 
    c.*,
    a.id_usuario,
    a.fecha_apertura,
    a.monto_inicial,
    a.b10000 AS ab10000,
    a.b2000 AS ab2000,
    a.b1000 AS ab1000,
    a.b500 AS ab500,
    a.b200 AS ab200,
    a.b100 AS ab100

    FROM cierre_caja c

    INNER JOIN apertura_caja a 
    ON c.id_apertura = a.id_apertura

    ORDER BY c.id_cierre DESC

    LIMIT 1
    ";


    $resultado = $conn->query($sql);


    if (!$resultado || $resultado->num_rows == 0) {

        echo "No hay cierres de caja registrados";
        exit();

    }

    $datos = $resultado->fetch_assoc();


    // Crear PDF

    $pdf = new FPDF();

    $pdf->AddPage();


    $pdf->SetFont("Arial","B",16);

    $pdf->Cell(0,10,"Farmil - Resumen de caja",0,1,"C");


    $pdf->Ln(10);


    $pdf->SetFont("Arial","",12);



    // APERTURA

    $pdf->Cell(0,10,"DATOS DE APERTURA",0,1);

    $pdf->Cell(0,10,"Fecha apertura: ".$datos['fecha_apertura'],0,1);

    $pdf->Cell(0,10,"Monto inicial: $".$datos['monto_inicial'],0,1);



    $pdf->Ln(5);



    $pdf->Cell(0,10,"Billetes apertura:",0,1);


    $pdf->Cell(0,8,"$10000: ".$datos['ab10000'],0,1);
    $pdf->Cell(0,8,"$2000: ".$datos['ab2000'],0,1);
    $pdf->Cell(0,8,"$1000: ".$datos['ab1000'],0,1);
    $pdf->Cell(0,8,"$500: ".$datos['ab500'],0,1);
    $pdf->Cell(0,8,"$200: ".$datos['ab200'],0,1);
    $pdf->Cell(0,8,"$100: ".$datos['ab100'],0,1);



    $pdf->Ln(10);



    // CIERRE

    $pdf->Cell(0,10,"DATOS DE CIERRE",0,1);


    $pdf->Cell(0,10,"Fecha cierre: ".$datos['fecha_cierre'],0,1);

    $pdf->Cell(0,10,"Monto final: $".$datos['monto_final'],0,1);



    $pdf->Ln(5);



    $pdf->Cell(0,10,"Billetes cierre:",0,1);


    $pdf->Cell(0,8,"$10000: ".$datos['b10000'],0,1);
    $pdf->Cell(0,8,"$2000: ".$datos['b2000'],0,1);
    $pdf->Cell(0,8,"$1000: ".$datos['b1000'],0,1);
    $pdf->Cell(0,8,"$500: ".$datos['b500'],0,1);
    $pdf->Cell(0,8,"$200: ".$datos['b200'],0,1);
    $pdf->Cell(0,8,"$100: ".$datos['b100'],0,1);





    // ===============================
    // VENTAS DEL DIA
    // ===============================


    $pdf->Ln(10);


    $pdf->Cell(0,10,"VENTAS DEL DIA",0,1);



    $sqlVentas = "

    SELECT 

    m.nombre,
    SUM(v.cantidad) AS cantidad_total,
    SUM(v.total) AS total_venta

    FROM ventas v

    INNER JOIN medicamentos m

    ON v.id_medicamento = m.id_medicamento

    WHERE DATE(v.fecha_venta) = CURDATE()

    GROUP BY v.id_medicamento

    ";



    $resultadoVentas = $conn->query($sqlVentas);



    if($resultadoVentas && $resultadoVentas->num_rows > 0){


        $pdf->Cell(60,10,"Medicamento",1);
        $pdf->Cell(40,10,"Cantidad",1);
        $pdf->Cell(40,10,"Total",1);

        $pdf->Ln();



        $totalDia = 0;



        while($venta = $resultadoVentas->fetch_assoc()){


            $pdf->Cell(60,10,$venta['nombre'],1);

            $pdf->Cell(40,10,$venta['cantidad_total'],1);

            $pdf->Cell(40,10,"$".$venta['total_venta'],1);


            $pdf->Ln();


            $totalDia += $venta['total_venta'];

        }



        $pdf->Ln(5);


        $pdf->Cell(0,10,"TOTAL VENDIDO DEL DIA: $".$totalDia,0,1);



    }else{


        $pdf->Cell(0,10,"No hay ventas registradas en el dia",0,1);


    }

    $pdf->Output("I","cierre_caja.pdf");

?>