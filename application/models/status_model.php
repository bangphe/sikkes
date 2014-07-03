<?php
class Status_model {
	/**
	 * Constructor
	 */
	 const STATUS_DRAFT = '0';
	 const STATUS_DEKON = '1';
	 const STATUS_DRAFT = '1';
	 const STATUS_DRAFT = '1';
	 
	0 - masih draft (masih di masing2 satker pengusul entah satker apapun)
	1 - ada di dekon/provinsi (butuh verifikasi provinsi)
	2 - ada di unit utama (butuh verifikasi unit utama)
	3 - ada di kementerian (perlu disetujui/ditolak/dipertimbangkan)
	4 - sudah disetujui di kementerian
	5 - sudah ditolak di kementerian
	6 - dipertimbangkan (nantinya bisa di setujui atau ditolak kalo ndak salah)
	7 - kalo ndak salah tidak diverifikasi di tingkat verifikator.. ditolak verifikator
	8 - di direktorat
}