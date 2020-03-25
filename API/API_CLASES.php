<?php
   class clasePedido{
		public function __construct($p1, $p2, $ofertaRefId){
			$this->P1 = $p1; $this->P2 = $p2; $this->OFERTA = $ofertaRefId;
		}
	};
    class claseOferta{
    	public function __construct($clienteRefId, $distRefId, $precio, $direRefId, $fecha, $hora, $demora, $estado, $lat, $lng){
			$this->CLIENTE = $clienteRefId;
			$this->DISTRIBUIDORES = $distRefId;
			$this->PRECIO = $precio;
			$this->DIRECCION = $direRefId;
			$this->FECHA = $fecha;
			$this->HORA = $hora;
			$this->DEMORA = $demora;
			$this->ESTADO = $estado;
			$this->LAT = $lat;
			$this->LNG = $lng;
		}
    };
?>