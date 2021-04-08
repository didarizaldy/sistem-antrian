<html>

<head>
    <title>Sistem Antrian</title>
    <link rel='StyleSheet' type='Text/css' href='style.css'>
</head>

<body> <br>
    <form method='post'>
        <table align='center' border=0 width=400 cellspacing=0>
            <tr>
                <td colspan=3 align='center'><b>
                        <font size=3 color='#444444'>Simulasi Antrian Tunggal</font>
                    </b></td>
            </tr>
            <tr>
                <td colspan=3>
                    <hr color='#888888' size=1>
                </td>
            </tr>
            <tr>
                <td align='right'>Rata-rata waktu antar kedatangan</td>
                <td width=10 align='center'>:</td>
                <td><input type='text' name='kedatangan'> menit</td>
            </tr>
            <tr>
                <td align='right'>Rata-rata waktu pelayanan</td>
                <td align='center'>:</td>
                <td><input type='text' name='pelayanan'> menit</td>
            </tr>
            <tr>
                <td align='right'>Banyaknya pelanggan</td>
                <td align='center'>:</td>
                <td><input type='text' name='banyak'> orang</td>
            </tr>
            <tr>
                <td colspan=3>
                    <hr color='#888888' size=1>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><input type='submit' value='Hitung'> <input type='reset' value='Reset'></td>
            </tr>
        </table>
    </form>
    <?php
    if ($_POST) {
        error_reporting(0);
        //	 && ($kedatangan%2==0 || $kedatangan%2==1 || $pelayanan%2==0 || $pelayanan%2==1 || $banyak%2==0 || $banyak%2==1)
        $kedatangan        = isset($_POST['kedatangan']) ? $_POST['kedatangan'] : "";
        $pelayanan        = isset($_POST['pelayanan']) ? $_POST['pelayanan'] : "";
        $banyak            = isset($_POST['banyak']) ? $_POST['banyak'] : "";
        if (empty($kedatangan) || empty($pelayanan) || empty($banyak)) {
            echo "<br><hr color='#888888' size=1><br><br><center>Maaf, data yang Anda masukan Salah !!!</center>";
        } else {
            $maxdatang        = $kedatangan * $banyak;
            $maxlayan        = $pelayanan * $banyak;
            $tampilacakdatang        = "";
            $tampiljumlahdatang        = "";
            $tampilacaklayan        = "";
            $tampiltunggudilayani    = "<td align='center'>0</td>";
            $jumlahtunggulayan        = 0;
            for ($i = 1; $i <= $banyak; $i++) {
                $acakdatang        = rand(1, $maxdatang);
                $jumlahdatang    += $acakdatang;
                $a[$i]            = $jumlahdatang;
                $pelangganke    .= "<td align='center' STYLE='border-bottom:1px solid #888888'>$i</td>";
                $tampilacakdatang    .= "<td align='center' width=50>$acakdatang</td>";
                $tampiljumlahdatang    .= "<td align='center'>$jumlahdatang</td>";
            }

            $tampilmenunggu = "<td align='center'>" . $a[1] . "</td>";
            $jumlahmenunggu = $a[1];

            for ($i = 1; $i <= $banyak; $i++) {
                $acaklayan        = rand(1, $maxlayan);
                $ok[$i] = $acaklayan;
                $selesailayan    = $a[$i] + $acaklayan;
                $jumlahselesailayan = $selesailayan;
                $tunggulayan[$i + 1]    = $selesailayan - $a[$i + 1];
                $menunggu[$i + 1]    = $a[$i + 1] - $selesailayan;
                $tampilacaklayan    .= "<td align='center'>$acaklayan</td>";
                $tampilselesailayan    .= "<td align='center'>$selesailayan</td>";
            }

            $tampilproses    = "<td align='center' style='border-bottom:1px solid #888888'>" . $ok[1] . "</td>";
            $jumlahproses = $ok[1];

            for ($i = 1; $i <= $banyak - 1; $i++) {
                if ($tunggulayan[$i + 1] < 0) {
                    $tunggulayan[$i + 1] = 0;
                }
                $tampiltunggudilayani    .= "<td align='center'>" . $tunggulayan[$i + 1] . "</td>";

                if ($menunggu[$i + 1] < 0) {
                    $menunggu[$i + 1] = 0;
                }
                $proses[$i + 1] = $tunggulayan[$i + 1] + $ok[$i + 1];
                $jumlahtunggulayan += $tunggulayan[$i + 1];
                $jumlahmenunggu += $menunggu[$i + 1];
                $jumlahproses    += $proses[$i + 1];
                $tampilmenunggu .= "<td align='center'>" . $menunggu[$i + 1] . "</td>";
                $tampilproses    .= "<td align='center' style='border-bottom:1px solid #888888'>" . $proses[$i + 1] . "</td>";
            }

            $ratatunggudilayani = $jumlahtunggulayan / $banyak;
            $rataproses         = $jumlahproses / $banyak;
            $ratapelanggandalamantrian = $jumlahtunggulayan / $jumlahselesailayan;
            $ratapelanggandlmsistem    = $jumlahproses / $jumlahselesailayan;
            $rit    = $jumlahmenunggu / $jumlahselesailayan;
            $persen = $rit * 100;

            $tampil = "
	<br><hr color='#888888' size=1><br><br>
	<table border=0 align='center' cellspacing=0 cellpadding=5>
	<tr>
		<td rowspan=2 align='center' STYLE='border:1px solid #888888'>Waktu</td>
		<td colspan=$banyak align='center' STYLE='border-bottom:1px solid #888888;border-top:1px solid #888888'>Pelanggan</td>
		<td rowspan=2 align='center' width=70 STYLE='border:1px solid #888888'>Total</td>
	</tr>
	<tr>
		$pelangganke
	</tr>
	<tr>
		<td STYLE='border-left:1px solid #888888;border-right:1px solid #888888'>Antar Kedatangan</td>
		$tampilacakdatang
		<td STYLE='border-left:1px solid #888888;border-right:1px solid #888888'>&nbsp;</td>
</tr>
	<tr>
		<td STYLE='border-left:1px solid #888888;border-right:1px solid #888888'>Kedatangan</td>
		$tampiljumlahdatang
		<td STYLE='border-left:1px solid #888888;border-right:1px solid #888888'>&nbsp;</td>
	</tr>
	<tr>
		<td STYLE='border-left:1px solid #888888;border-right:1px solid #888888'>Pelayanan</td>
		$tampilacaklayan
		<td STYLE='border-left:1px solid #888888;border-right:1px solid #888888'>&nbsp;</td>
	</tr>
	<tr>
		<td STYLE='border-left:1px solid #888888;border-right:1px solid #888888'>Selesai Dilayani</td>
		$tampilselesailayan
		<td STYLE='border-left:1px solid #888888;border-right:1px solid #888888'>&nbsp;</td>
	</tr>
	<tr>
		<td STYLE='border-left:1px solid #888888;border-right:1px solid #888888'>Tunggu Dilayani</td>
		$tampiltunggudilayani
		<td align='center' STYLE='border-left:1px solid #888888;border-right:1px solid #888888'>$jumlahtunggulayan</td>
	</tr>
	<tr>
		<td STYLE='border-left:1px solid #888888;border-right:1px solid #888888'>Menunggu Pelanggan</td>
		$tampilmenunggu
		<td align='center' STYLE='border-left:1px solid #888888;border-right:1px solid #888888'>$jumlahmenunggu</td>
	</tr>
	<tr>
		<td STYLE='border-left:1px solid #888888;border-right:1px solid #888888;border-bottom:1px solid #888888'>Proses</td>
		$tampilproses
		<td align='center' STYLE='border-left:1px solid #888888;border-right:1px solid #888888;border-bottom:1px solid #888888'>$jumlahproses</td>
	</tr>
	<tr>
		<td colspan=$banyak+2>
			Rata-rata waktu tunggu dilayani : " . number_format($ratatunggudilayani, 2, ',', '.') . " menit<br>
			Rata-rata waktu proses pelayanan pelanggan : " . number_format($rataproses, 2, ',', '.') . " menit<br>	
			Rata-rata banyak pelanggan dalam antrian : " . number_format($ratapelanggandalamantrian, 2, ',', '.') . " = " . ceil($ratapelanggandalamantrian) . " pelanggan<br>
			Rata-rata banyaknya pelanggan dlm sistem : " . number_format($ratapelanggandlmsistem, 2, ',', '.') . " = " . ceil($ratapelanggandlmsistem) . " pelanggan<br><br>
			Rasio waktu menunggu pelanggan (RIT) : " . number_format($rit, 2, ',', '.') . " <br>
			Dengan kata lain pelayanan yang dioperasikan dari seluruh waktu pelayanan " . number_format($persen, 0, ',', '.') . " % merupakan waktu kosong (luang)
		</td>
	</tr>
	</table>
";

            echo $tampil;
        }
    }

    ?>
</body>

</html>