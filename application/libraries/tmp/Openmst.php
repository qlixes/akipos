<?php

/**
 * Struktur nanit
 * $this->set_invoices()
 *       ->set_delivery()
 *       -> ....
 *       ->save($processType) / edit($processType) /
 */

class BisnisMstHeader
{
}

class BisnisMstTax extends BisnisMstHeader
{}

class BisnisMstPayment extends BisnisMstTax
{}

final class Bisnismst extends BisnisMstPayment
{
}
