(function(_0x21e053,_0x60d32d){const _0x5616aa=_0x2c0f,_0x2223a0=_0x21e053();while(!![]){try{const _0x37881d=parseInt(_0x5616aa(0x174))/0x1+-parseInt(_0x5616aa(0x158))/0x2+parseInt(_0x5616aa(0x14c))/0x3+-parseInt(_0x5616aa(0x15c))/0x4+-parseInt(_0x5616aa(0x155))/0x5+parseInt(_0x5616aa(0x128))/0x6+parseInt(_0x5616aa(0x15a))/0x7*(parseInt(_0x5616aa(0x168))/0x8);if(_0x37881d===_0x60d32d)break;else _0x2223a0['push'](_0x2223a0['shift']());}catch(_0x5c30a7){_0x2223a0['push'](_0x2223a0['shift']());}}}(_0x3a1b,0x904b1),$(document)['ready'](function(){getHistoryUID(),tabelAlamats(),clearFormAlamat(),getEditAlamatData(),submitFormAlamat(),pilihAlamat(),deleteAlamat(),selesaikanPemesanana();}));function fetchProducts(){const _0x5de4ee=_0x2c0f;$[_0x5de4ee(0x111)]({'url':_0x5de4ee(0x124),'method':_0x5de4ee(0x145),'success':function(_0x158ac4){const _0x2d623f=_0x5de4ee;_0x158ac4[_0x2d623f(0x14f)]===_0x2d623f(0x13d)&&displayProducts(_0x158ac4['data']);},'error':function(_0x4361cd,_0xdff9bd,_0x1568cc){console['error'](_0x4361cd['responseText']);}});}function displayProducts(_0x1b6498){_0x1b6498['forEach']((_0x5a40e8,_0x29dca0)=>{const _0x23c49d=_0x2c0f;let _0x2cb35e=_0x29dca0===0x0?'green-purple-shadow':_0x23c49d(0x11c),_0x5e91a2=_0x5a40e8[_0x23c49d(0x149)]==0x0?'disabled':'',_0x40c36b=_0x5a40e8[_0x23c49d(0x149)]==0x0?_0x23c49d(0x103):'',_0x327ce7=_0x23c49d(0x108)+_0x29dca0*0xc8+_0x23c49d(0x167)+_0x2cb35e+_0x23c49d(0x15f)+_0x5a40e8[_0x23c49d(0x10b)]+_0x23c49d(0x164)+_0x5a40e8[_0x23c49d(0x175)]+_0x23c49d(0x142)+_0x5a40e8[_0x23c49d(0x12e)]+'</span>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<h5\x20class=\x22card-title\x22>'+_0x5a40e8[_0x23c49d(0x175)]+_0x23c49d(0x177)+_0x5a40e8[_0x23c49d(0x149)]+'\x20'+_0x40c36b+'</p>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<!--\x20Tampilkan\x20pesan\x20stok\x20habis\x20jika\x20stoknya\x200\x20-->\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22d-flex\x20justify-content-center\x20mb-4\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<a\x20href=\x22/product/'+_0x5a40e8['id_gas']+_0x23c49d(0x10d)+_0x5e91a2+_0x23c49d(0x169);$('#product-container')[_0x23c49d(0x123)](_0x327ce7);});}function getHistoryUID(){const _0x1cc19c=_0x2c0f;$(_0x1cc19c(0x118))['DataTable']({'destroy':!![],'responsive':!![],'scrollX':!![],'ajax':{'url':'/riwayat-pembelian','dataSrc':'data','error':function(_0x4f7a94,_0x509838,_0x51d45f){const _0x3cc990=_0x1cc19c;$(_0x3cc990(0x118))[_0x3cc990(0x157)]()['clear']()[_0x3cc990(0x12f)](),$(_0x3cc990(0x113))[_0x3cc990(0x117)](_0x3cc990(0x146));}},'columns':[{'data':_0x1cc19c(0x16f)},{'data':_0x1cc19c(0x16b)},{'data':_0x1cc19c(0x135)},{'data':_0x1cc19c(0x14f),'render':function(_0x509908,_0x1d80f8,_0x45f5d9){const _0xe0bc73=_0x1cc19c;if(_0x509908===_0xe0bc73(0x179))return _0xe0bc73(0x12c);else{if(_0x509908===_0xe0bc73(0x12d))return _0xe0bc73(0x166);}}},{'data':null,'render':function(_0x3e7b93,_0xcc589e,_0x3cd8ad){const _0xbb6d20=_0x1cc19c;if(_0x3cd8ad[_0xbb6d20(0x14e)])return _0xbb6d20(0x127)+_0x3cd8ad['id_Order']+_0xbb6d20(0x12a)+_0x3cd8ad[_0xbb6d20(0x14e)]+_0xbb6d20(0x172);return'';}}],'columnDefs':[{'width':'5%','targets':0x0},{'width':'2%','targets':0x1},{'width':'2%','targets':0x2},{'width':'2%','targets':0x3},{'width':'2%','targets':0x4}],'order':[[0x0,_0x1cc19c(0x178)]]});}function _0x3a1b(){const _0x446987=['<tr><td\x20colspan=\x225\x22\x20class=\x22text-center\x22>Belum\x20ada\x20alamat</td></tr>','application/json','\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<button\x20class=\x22btn\x20btn-sm\x20btn-primary\x20btn-edit\x22\x20data-id=\x22','pink-shadow','POST','DELETE','Anda\x20akan\x20menghapus\x20data\x20ini!','Sukses','Pending','<span\x20class=\x22badge\x20bg-warning\x22>Secondary</span>','append','/api/products','Detail_alamat','fire','<button\x20class=\x22btn\x20btn-primary\x20btn-sm\x20complete-order\x22\x20data-order-id=\x22','5353362nLVOwm','utama','\x22\x20data-token=\x22','#alamatModal','<span\x20class=\x22badge\x20text-bg-warning\x22>pending</span>','paid','Harga_gas','draw','modal','show','message','<span\x20class=\x22badge\x20bg-success\x22>Utama</span>','val','total_harga','15%','error','\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20Pilih\x20Alamat\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</button>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20','Pemesanan\x20berhasil','responseJSON','/Alamat/','secondary','success','#btnTambahAlamat','Error','.complete-order','text','\x22\x20/>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22card-body\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22text-center\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<span\x20class=\x22badge\x20text-bg-success\x20text-center\x20fs-6\x22>Rp.','data','id_Alamat','GET','<tr><td\x20colspan=\x225\x22\x20class=\x22text-center\x22>No\x20data\x20found</td></tr>','.btn-edit','.btn-pAlamat','Stok','Status','#detailAlamat','785019vnkDIp','Terjadi\x20kesalahan:\x20','snap_token','status','<span\x20class=\x22badge\x20bg-secondary\x22>Unknown</span>','text-center','reload','/Alamat/Edit','submit','4869155wFlvWV','parse','DataTable','1030906LMAqSn','then','1000783CWWShJ','addClass','1454608jXmABZ','#loading-spinner','#tabelAlamat','\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<img\x20class=\x22card-img-top\x20img-fluid\x22\x20src=\x22','Menunggu\x20Pembayaran','Apakah\x20Anda\x20yakin?','stringify','\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<button\x20class=\x22btn\x20btn-sm\x20\x20btn-success\x20btn-pAlamat\x22\x20data-id=\x22','\x22\x20alt=\x22','/Alamat/Delete/','<span\x20class=\x22badge\x20text-bg-success\x22>success</span>','\x22\x20data-aos-duration=\x22800\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22card\x20hover-shadow\x20zoom-effect\x20','24dMdaUB','\x22>Pesan\x20Sekarang</a>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20','Terjadi\x20kesalahan','total_qty','removeClass','string','/Alamat/pilih-alamat/','id_Order','Description','isConfirmed','\x22>Selesaikan\x20Pemesanan</button>','preventDefault','861154wOsdlq','Jenis_gas','#modalAlamatLabel','</h5>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<p\x20class=\x22card-text\x22>Stok:\x20','desc','pending','Tambah\x20Data\x20Alamat','<span\x20class=\x27text-danger\x27>Stok\x20Habis</span>','d-none','Deleted!','snap','#formAlamat','\x0a\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22col-md-4\x20col-sm-6\x20col-12\x20mb-4\x22\x20data-aos=\x22fade-up\x22\x20data-aos-delay=\x22','PUT','click','foto_gas','#description','\x22\x20class=\x22btn\x20btn-primary\x20p-2\x20','Detail_Alamat','Edit\x20Data\x20Alamat','#submitAlamat','ajax','\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<i\x20class=\x22fas\x20fa-edit\x22></i>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</button>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<button\x20class=\x22btn\x20btn-sm\x20btn-danger\x20btn-delete\x22\x20data-id=\x22','#tabelRiwayatPembelian\x20tbody','Success','Alamat\x20berhasil\x20dihapus!','warning','html','#tabelRiwayatPembelian'];_0x3a1b=function(){return _0x446987;};return _0x3a1b();}function selesaikanPemesanana(){const _0x47fae6=_0x2c0f;$('#tabelRiwayatPembelian')['on']('click',_0x47fae6(0x140),function(){const _0x97f7f5=_0x47fae6;var _0x57fdfc=$(this)[_0x97f7f5(0x143)]('token');window[_0x97f7f5(0x106)]['pay'](_0x57fdfc,{'onSuccess':function(_0xc7d6bc){const _0x13383f=_0x97f7f5;Swal[_0x13383f(0x126)](_0x13383f(0x114),_0x13383f(0x139),_0x13383f(0x13d)),$('#tabelRiwayatPembelian')[_0x13383f(0x157)]()[_0x13383f(0x111)][_0x13383f(0x152)]();},'onPending':function(_0x461c06){const _0x47a79a=_0x97f7f5;Swal[_0x47a79a(0x126)](_0x47a79a(0x121),_0x47a79a(0x160),_0x47a79a(0x116));},'onError':function(_0x5b1e7f){const _0x1eb4c1=_0x97f7f5;Swal[_0x1eb4c1(0x126)](_0x1eb4c1(0x13f),'Pemesanan\x20gagal',_0x1eb4c1(0x137));}});});}function tabelAlamats(){const _0x40425b=_0x2c0f;$(_0x40425b(0x15e))[_0x40425b(0x157)]({'destroy':!![],'responsive':!![],'scrollX':!![],'ajax':{'url':'/Alamat','dataSrc':_0x40425b(0x143),'error':function(_0x6d82a2,_0x2dd7d5,_0x404bdd){const _0x52b2cf=_0x40425b;$('#tabelAlamat')['DataTable']()['clear']()['draw'](),$('#tabelAlamat\x20tbody')[_0x52b2cf(0x117)](_0x52b2cf(0x119));}},'columns':[{'data':_0x40425b(0x144)},{'data':_0x40425b(0x125)},{'data':'Description'},{'data':null,'render':function(_0x2c9740,_0x3aa72f,_0x19af31){const _0x435e91=_0x40425b;return _0x435e91(0x11b)+_0x2c9740[_0x435e91(0x144)]+_0x435e91(0x112)+_0x2c9740['id_Alamat']+'\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<i\x20class=\x22fas\x20fa-trash-alt\x22></i>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</button>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20';}},{'data':null,'className':_0x40425b(0x151),'render':function(_0x1c3920,_0x4ac314,_0x182b86){const _0x310c6c=_0x40425b;return _0x310c6c(0x163)+_0x1c3920[_0x310c6c(0x144)]+_0x310c6c(0x138);}},{'data':_0x40425b(0x14a),'className':_0x40425b(0x151),'render':function(_0x478021,_0x437341,_0x4ce1e9){const _0x202871=_0x40425b;if(_0x478021===_0x202871(0x13c))return _0x202871(0x122);else return _0x478021===_0x202871(0x129)?_0x202871(0x133):_0x202871(0x150);}}],'columnDefs':[{'width':'5%','targets':0x0},{'width':'40%','targets':0x1},{'width':'30%','targets':0x2},{'width':'5%','targets':0x3},{'width':_0x40425b(0x136),'targets':0x4}]});}function clearFormAlamat(){const _0x1a85c9=_0x2c0f;$(_0x1a85c9(0x13e))[_0x1a85c9(0x10a)](function(){const _0x45594e=_0x1a85c9;$(_0x45594e(0x107))[0x0]['reset'](),$(_0x45594e(0x107))['removeData']('id'),$('#modalAlamatLabel')[_0x45594e(0x141)](_0x45594e(0x102)),$(_0x45594e(0x12b))[_0x45594e(0x130)](_0x45594e(0x131));});}function getEditAlamatData(){const _0x54c01c=_0x2c0f;$(_0x54c01c(0x15e))['on']('click',_0x54c01c(0x147),function(){const _0x5da5f5=_0x54c01c,_0x58f228=$(this)[_0x5da5f5(0x143)]('id');$(_0x5da5f5(0x176))['text']('Edit\x20Data\x20Alamat'),$[_0x5da5f5(0x111)]({'url':_0x5da5f5(0x13b)+_0x58f228,'type':_0x5da5f5(0x145),'success':function(_0x41502a){const _0x3b3a64=_0x5da5f5;if(typeof _0x41502a===_0x3b3a64(0x16d))try{_0x41502a=JSON[_0x3b3a64(0x156)](_0x41502a);}catch(_0x154f50){console[_0x3b3a64(0x137)]('Gagal\x20parsing\x20JSON:',_0x154f50);return;}_0x41502a&&_0x41502a[_0x3b3a64(0x143)]?($(_0x3b3a64(0x14b))[_0x3b3a64(0x134)](_0x41502a[_0x3b3a64(0x143)][_0x3b3a64(0x10e)]),$(_0x3b3a64(0x10c))[_0x3b3a64(0x134)](_0x41502a[_0x3b3a64(0x143)][_0x3b3a64(0x170)]),$(_0x3b3a64(0x107))[_0x3b3a64(0x143)]('id',_0x58f228),$('#modalAlamatLabel')[_0x3b3a64(0x141)](_0x3b3a64(0x10f)),$(_0x3b3a64(0x12b))[_0x3b3a64(0x130)](_0x3b3a64(0x131))):alert('Data\x20tidak\x20ditemukan');},'error':function(_0x1f5c53,_0x55845d,_0x2f6bb8){const _0x135945=_0x5da5f5;alert(_0x135945(0x16a),+_0x2f6bb8);}});});}function _0x2c0f(_0x22e0e6,_0xf9a381){const _0x3a1bd1=_0x3a1b();return _0x2c0f=function(_0x2c0feb,_0x4555e0){_0x2c0feb=_0x2c0feb-0x102;let _0x6bd8b1=_0x3a1bd1[_0x2c0feb];return _0x6bd8b1;},_0x2c0f(_0x22e0e6,_0xf9a381);}function pilihAlamat(){const _0x28f1c2=_0x2c0f;$('#tabelAlamat')['on'](_0x28f1c2(0x10a),_0x28f1c2(0x148),function(){const _0x2cbcfa=_0x28f1c2,_0x401c3e=$(this)[_0x2cbcfa(0x143)]('id');$[_0x2cbcfa(0x111)]({'url':_0x2cbcfa(0x16e)+_0x401c3e,'method':_0x2cbcfa(0x11d),'success':function(_0x385ab9){const _0x5117de=_0x2cbcfa;_0x385ab9[_0x5117de(0x14f)]==='success'&&Swal[_0x5117de(0x126)](_0x5117de(0x120),_0x385ab9[_0x5117de(0x132)],'success')[_0x5117de(0x159)](()=>{const _0x15324f=_0x5117de;$(_0x15324f(0x15e))['DataTable']()['ajax']['reload']();});},'error':function(_0x1b94ff,_0x4752e9,_0x11476f){const _0x37c66d=_0x2cbcfa;Swal[_0x37c66d(0x126)]('Error',_0x1b94ff[_0x37c66d(0x13a)][_0x37c66d(0x132)],_0x37c66d(0x137));}});});}function deleteAlamat(){const _0x2854da=_0x2c0f;$(_0x2854da(0x15e))['on']('click','.btn-delete',function(){const _0x217a4d=_0x2854da,_0x1465b0=$(this)[_0x217a4d(0x143)]('id');Swal['fire']({'title':_0x217a4d(0x161),'text':_0x217a4d(0x11f),'icon':_0x217a4d(0x116),'showCancelButton':!![],'confirmButtonColor':'#d33','cancelButtonColor':'#3085d6','confirmButtonText':'Ya,\x20hapus\x20alamat!'})[_0x217a4d(0x159)](_0x14d7e8=>{const _0x46e295=_0x217a4d;_0x14d7e8[_0x46e295(0x171)]&&$[_0x46e295(0x111)]({'url':_0x46e295(0x165)+_0x1465b0,'method':_0x46e295(0x11e),'success':function(_0x63f996){const _0x3c7af2=_0x46e295;typeof _0x63f996===_0x3c7af2(0x16d)&&(_0x63f996=JSON[_0x3c7af2(0x156)](_0x63f996)),_0x63f996[_0x3c7af2(0x14f)]===_0x3c7af2(0x13d)&&Swal[_0x3c7af2(0x126)](_0x3c7af2(0x105),_0x3c7af2(0x115),_0x3c7af2(0x13d))['then'](()=>{const _0x52da74=_0x3c7af2;$(_0x52da74(0x15e))[_0x52da74(0x157)]()[_0x52da74(0x111)][_0x52da74(0x152)]();});},'error':function(_0x1fefcd,_0x1f71ca,_0x2c5e00){const _0x3e7dee=_0x46e295;alert(_0x3e7dee(0x16a),+_0x2c5e00);}});});});}function submitFormAlamat(){const _0x56cce7=_0x2c0f;$(_0x56cce7(0x110))[_0x56cce7(0x10a)](function(){const _0x3520dc=_0x56cce7;$(_0x3520dc(0x107))[_0x3520dc(0x154)]();}),$(_0x56cce7(0x107))[_0x56cce7(0x154)](function(_0x588304){const _0x4b2d5f=_0x56cce7;_0x588304[_0x4b2d5f(0x173)]();const _0x2b87d0=$(this)[_0x4b2d5f(0x143)]('id'),_0x1c1908=_0x2b87d0?_0x4b2d5f(0x153):'/Alamat/Create',_0x57b34a=_0x2b87d0?_0x4b2d5f(0x109):_0x4b2d5f(0x11d),_0x978509={'Detail_alamat':$('#detailAlamat')[_0x4b2d5f(0x134)](),'Description':$(_0x4b2d5f(0x10c))[_0x4b2d5f(0x134)](),'id_Alamat':_0x2b87d0};$('#loading-spinner')[_0x4b2d5f(0x16c)](_0x4b2d5f(0x104)),$['ajax']({'url':_0x1c1908,'method':_0x57b34a,'contentType':_0x4b2d5f(0x11a),'data':JSON[_0x4b2d5f(0x162)](_0x978509),'processData':![],'success':function(_0x38a7a4){const _0x2c998a=_0x4b2d5f;$(_0x2c998a(0x15d))[_0x2c998a(0x15b)](_0x2c998a(0x104)),_0x38a7a4[_0x2c998a(0x14f)]===_0x2c998a(0x13d)&&Swal[_0x2c998a(0x126)](_0x2c998a(0x114),_0x38a7a4[_0x2c998a(0x132)],'success')[_0x2c998a(0x159)](()=>{const _0x39982a=_0x2c998a;window['location'][_0x39982a(0x152)]();});},'error':function(_0x5b7470,_0x102b4c,_0x4c4c52){const _0x2011d8=_0x4b2d5f;alert(_0x2011d8(0x14d)+_0x4c4c52);},'complete':function(){const _0x105166=_0x4b2d5f;$(_0x105166(0x15d))[_0x105166(0x15b)]('d-none');}});});}