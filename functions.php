<?php

    function cari_jam_ramai($data_pengunjung) {
        // inisialisasi array kosong untuk menyimpan jumlah pengunjung pada setiap jam
        $jumlah_pengunjung = array();
    
        // memisahkan data pengunjung berdasarkan baris
        $baris_pengunjung = explode("\n", $data_pengunjung);
    
        // mengolah data pengunjung pada setiap baris
        foreach ($baris_pengunjung as $baris) {
            // memisahkan data pengunjung pada setiap baris berdasarkan koma
            $data = explode(",", $baris);
    
            // memeriksa apakah format data pengunjung sudah benar
            if (count($data) == 4) {
                $hari = $data[0];
                $jam = $data[1];
                $pengunjung = $data[2];
                $penjualan = $data[3];
    
                // menambahkan jumlah pengunjung pada setiap jam
                if (!isset($jumlah_pengunjung[$hari][$jam])) {
                    $jumlah_pengunjung[$hari][$jam] = 0;
                }
                $jumlah_pengunjung[$hari][$jam] += $pengunjung;
            }
        }
    
        // mencari jam ramai pada setiap hari
        $jam_ramai = array();
        foreach ($jumlah_pengunjung as $hari => $jumlah) {
            $jam_ramai[$hari] = array('jam' => '', 'pengunjung' => 0);
            foreach ($jumlah as $jam => $jumlah_pengunjung) {
                if ($jumlah_pengunjung > $jam_ramai[$hari]['pengunjung']) {
                    $jam_ramai[$hari]['jam'] = $jam;
                    $jam_ramai[$hari]['pengunjung'] = $jumlah_pengunjung;
                }
            }
        }
    
        return $jam_ramai;
    }

    function hitung_penjualan_per_hari($data, $hari) {
        $penjualan = 0;
        foreach($data as $row) {
            $row_data = explode(",", $row);
            if($row_data[0] == $hari) {
                $penjualan += intval($row_data[3]);
            }
        }
        return $penjualan;
    }
    
    
    function hitung_jam_ramai_dan_penjualan($data_pengunjung) {
        $data_per_hari = array();
        $data_per_jam = array();
        $jam_ramai = array();
        $penjualan_per_hari = array();
    
        // mengubah data menjadi array
        $data_array = explode("\n", $data_pengunjung);
    
        // menghitung jumlah pengunjung dan penjualan pada setiap jam
        foreach ($data_array as $data) {
            $record = explode(",", $data);
            $hari = trim($record[0]);
            $jam = trim($record[1]);
            $pengunjung = (int) trim($record[2]);
            $penjualan = (float) trim($record[3]);
    
            if (!isset($data_per_hari[$hari])) {
                $data_per_hari[$hari] = array();
                $penjualan_per_hari[$hari] = 0;
            }
    
            if (!isset($data_per_jam[$hari][$jam])) {
                $data_per_jam[$hari][$jam] = array();
            }
    
            $data_per_hari[$hari][] = $pengunjung;
            $data_per_jam[$hari][$jam][] = $pengunjung;
    
            $penjualan_per_hari[$hari] += $penjualan;
        }
    
        // mencari jam ramai pada setiap harinya
        foreach ($data_per_jam as $hari => $data_jam) {
            $jam_tertinggi = '';
            $jumlah_pengunjung_tertinggi = 0;
    
            foreach ($data_jam as $jam => $data) {
                $jumlah_pengunjung = array_sum($data);
    
                if ($jumlah_pengunjung > $jumlah_pengunjung_tertinggi) {
                    $jam_tertinggi = $jam;
                    $jumlah_pengunjung_tertinggi = $jumlah_pengunjung;
                }
            }
    
            $jam_ramai[$hari] = array(
                'jam' => $jam_tertinggi,
                'pengunjung' => $jumlah_pengunjung_tertinggi,
                'penjualan' => $penjualan_per_hari[$hari]
            );
        }
    
        return $jam_ramai;
    }

    function cari_penjualan_tertinggi($data_pengunjung) {
        $penjualan_tertinggi = array();
        
        // memisahkan data per hari
        $data_per_hari = explode("\n", $data_pengunjung);
        
        foreach ($data_per_hari as $data_hari) {
            $data = explode(",", $data_hari);
            $hari = $data[0];
            $jam = $data[1];
            $penjualan = (int) $data[3];
            
            // jika belum ada data penjualan untuk hari tersebut, inisialisasi dengan 0
            if (!isset($penjualan_tertinggi[$hari])) {
                $penjualan_tertinggi[$hari] = array(
                    'jam' => $jam,
                    'penjualan_tertinggi' => 0,
                    'penjualan_terendah' => 0
                );
            }
            
            // update penjualan tertinggi dan terendah jika penjualan saat ini lebih besar atau lebih kecil
            if ($penjualan > $penjualan_tertinggi[$hari]['penjualan_tertinggi']) {
                $penjualan_tertinggi[$hari]['jam'] = $jam;
                $penjualan_tertinggi[$hari]['penjualan_tertinggi'] = $penjualan;
            }
            
            if ($penjualan < $penjualan_tertinggi[$hari]['penjualan_terendah'] || $penjualan_tertinggi[$hari]['penjualan_terendah'] == 0) {
                $penjualan_tertinggi[$hari]['penjualan_terendah'] = $penjualan;
            }
        }
        
        return $penjualan_tertinggi;
    }

    function urutkan_hari_penjualan($data_pengunjung) {
        $penjualan_harian = array();
      
        // menghitung penjualan harian
        foreach (explode("\n", $data_pengunjung) as $data) {
          $data = explode(",", $data);
          $hari = trim($data[0]);
          $penjualan = floatval(trim($data[3]));
      
          if (!isset($penjualan_harian[$hari])) {
            $penjualan_harian[$hari] = $penjualan;
          } else {
            $penjualan_harian[$hari] += $penjualan;
          }
        }
      
        // mengurutkan penjualan harian dari tertinggi ke terendah
        arsort($penjualan_harian);
      
        return $penjualan_harian;
      }
      
    
    
    
