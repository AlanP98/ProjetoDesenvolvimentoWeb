<?php

class ExporterFactoryProvider {

	public function create(string $type) {
		$exporterClass = 'Exporter' . $type . 'Provider';
		$classPath = DIR . 'Factorys/Exporter/' . $exporterClass . '.php';

		if (file_exists($classPath)) {
			require_once $classPath;

			if (class_exists($exporterClass, false)) {
				return new $exporterClass();
			} else {
				echo '<br> Classe não exixte.';
			}

		} else {
			echo '<br> Arquivo não existe.';
		}

		throw new Exception('Tipo de exportador indisponível.');
	}

}