<?php

interface IExporterProvider {
	function createExporterPerson() : ExporterPerson;
	function createExporterProduct() : ExporterProduct;
}