const _0x1648c8=_0x2642;(function(_0x505645,_0x48c3f3){const _0x577097=_0x2642,_0x486846=_0x505645();while(!![]){try{const _0x2d51be=-parseInt(_0x577097(0x152))/0x1+parseInt(_0x577097(0x160))/0x2+parseInt(_0x577097(0x180))/0x3+-parseInt(_0x577097(0x195))/0x4*(parseInt(_0x577097(0x147))/0x5)+parseInt(_0x577097(0x142))/0x6*(-parseInt(_0x577097(0x1a2))/0x7)+-parseInt(_0x577097(0x155))/0x8*(-parseInt(_0x577097(0x17c))/0x9)+parseInt(_0x577097(0x181))/0xa;if(_0x2d51be===_0x48c3f3)break;else _0x486846['push'](_0x486846['shift']());}catch(_0x29d235){_0x486846['push'](_0x486846['shift']());}}}(_0x4507,0xc4095),$(document)[_0x1648c8(0x18f)](function(){const _0x4b23c0=_0x1648c8;getAllCartUID(),handleQtyButtonCart(),getAlamat(),handleDeliveryOption(),$(_0x4b23c0(0x168))[_0x4b23c0(0x166)](handleDeliveryOption),$('#selectAll')['change'](handleSelectAll),$(document)['on'](_0x4b23c0(0x163),_0x4b23c0(0x151),function(){const _0x411144=_0x4b23c0,_0x59f49c=$(this)[_0x411144(0x13f)]('id');deleteCartItem(_0x59f49c);}),cartCheckouts();}));function renderCartItem(_0x4dec7b){const _0x1e4591=_0x1648c8;return'\x0a\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22card\x20mb-4\x20shadow-sm\x22\x20data-product-id=\x22'+_0x4dec7b[_0x1e4591(0x17a)]+_0x1e4591(0x14b)+_0x4dec7b[_0x1e4591(0x18e)]+'\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22product-image\x20me-3\x20mb-3\x20mb-md-0\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<img\x20src=\x22../'+_0x4dec7b['foto_gas']+'\x22\x20class=\x22img-fluid\x20rounded\x22\x20style=\x22width:\x2080px;\x22\x20alt=\x22Product\x20Image\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22flex-grow-1\x20text-center\x20text-md-start\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<h5\x20class=\x22card-title\x20mb-1\x22><span\x20id=\x22jenisGas\x22>'+_0x4dec7b[_0x1e4591(0x176)]+_0x1e4591(0x139)+_0x4dec7b[_0x1e4591(0x19e)]+_0x1e4591(0x183)+_0x4dec7b[_0x1e4591(0x191)]+_0x1e4591(0x140)+_0x4dec7b[_0x1e4591(0x18e)]+_0x1e4591(0x167)+_0x4dec7b[_0x1e4591(0x18e)]+_0x1e4591(0x172)+_0x4dec7b[_0x1e4591(0x19e)]+_0x1e4591(0x15a)+_0x4dec7b[_0x1e4591(0x18e)]+'\x22\x20data-id=\x22'+_0x4dec7b[_0x1e4591(0x18e)]+_0x1e4591(0x161)+_0x4dec7b[_0x1e4591(0x179)]+_0x1e4591(0x17b)+_0x4dec7b[_0x1e4591(0x18e)]+_0x1e4591(0x172)+_0x4dec7b[_0x1e4591(0x19e)]+'\x22>+</button>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<button\x20class=\x22btn\x20btn-outline-danger\x20btn-sm\x20btn-delete\x22\x20data-id=\x22'+_0x4dec7b[_0x1e4591(0x18e)]+'\x22><i\x20class=\x22fas\x20fa-trash\x22></i></button>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20';}function _0x4507(){const _0x49ca05=['</span></h5>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<p\x20class=\x22card-text\x20text-muted\x20small\x22>Stok\x20:\x20<span\x20class=\x22stok-title\x22>','#cart-qty-','Item\x20ini\x20akan\x20dihapus\x20dari\x20keranjang!','stock','#btn-beli','Pilih\x20metode\x20pengambilan','data','</span><br>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<span>Total\x20Price:\x20<span\x20id=\x22total-price-','message','90toVcdg','POST','ajax','toLocaleString','Apakah\x20anda\x20yakin\x20ingin\x20melakukan\x20pembelian\x20pada\x20barang\x20ini?','5yAwxEh','#delivery-cost','Konfirmasi\x20Pembelian','#total-price-','\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22card-body\x20d-flex\x20flex-column\x20flex-md-row\x20align-items-center\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22me-3\x20mb-3\x20mb-md-0\x20d-flex\x20align-items-center\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<input\x20type=\x22checkbox\x22\x20class=\x22cart-checkbox\x22\x20data-id=\x22','length','responseJSON','.cart-qty','Yes,\x20delete\x20it!','Rp\x20','.btn-delete','1584476jjQNHn','delivery','token','16752KuZRXA','replace','Dihapus','/api/carts/','find','\x22>-</button>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<input\x20type=\x22text\x22\x20class=\x22form-control\x20text-center\x20mx-2\x20cart-qty\x22\x20id=\x22cart-qty-','append','val','pay','/checkout-carts','DELETE','3105560aBVecF','\x22\x20value=\x22','application/json','click','closest',':checked','change','\x22>Rp\x200</span></span><br>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22d-flex\x20align-items-center\x20mb-2\x20mb-md-0\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<button\x20class=\x22btn\x20btn-outline-secondary\x20btn-sm\x20btn-decrease\x22\x20data-id=\x22','#delivery-option','.cart-checkbox','each','.btn-decrease','Detail_alamat','then','Jumlah\x20melebihi\x20stok!','#jenisGas','push','#u-alamat','\x22\x20data-stock=\x22','Metode\x20Pengambilan','prop','Checkout','Jenis_gas','Rp\x20-','fire','Qty','id_gas','\x22\x20style=\x22width:\x2050px;\x22\x20readonly>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<button\x20class=\x22btn\x20btn-outline-secondary\x20btn-sm\x20btn-increase\x22\x20data-id=\x22','5121lvlgDY','product-id','text','.btn-increase','855777xhgimR','15608220vBYXUk','.cart-checkbox:checked','</span></p>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22d-flex\x20justify-content-between\x20align-items-center\x20flex-column\x20flex-md-row\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22mb-2\x20mb-md-0\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<span\x20class=\x22text-success\x20fw-bold\x22>Rp','reload','error','location','stringify','attr','#cart-container\x20input[type=\x22checkbox\x22]:checked','warning','isConfirmed','checked','Error','cart_id','ready','#d33','harga_unit','#3085d6','#d-alamat','Tidak\x20ada\x20item\x20yang\x20dipilih','6065784ceuoMI','#selectAll','siblings','question','#total-cost','.text-success','hide','#cart-container','.card-body','Stok','log','GET','id_Alamat','320348XndblS','Gagal','Failed\x20to\x20receive\x20transaction\x20token','Batal','Payment\x20success:'];_0x4507=function(){return _0x49ca05;};return _0x4507();}function handleQtyButtonCart(){const _0x1a10be=_0x1648c8;$(document)['on']('click',_0x1a10be(0x17f),function(){const _0x28455d=_0x1a10be;let _0x9c9e4c=$(this)['data'](_0x28455d(0x13c)),_0x2844c4=$(this)['siblings'](_0x28455d(0x14e)),_0x15c1f7=parseInt(_0x2844c4['val']());_0x15c1f7<_0x9c9e4c?(_0x15c1f7++,_0x2844c4['val'](_0x15c1f7),$(this)[_0x28455d(0x164)](_0x28455d(0x19d))['find'](_0x28455d(0x169))[_0x28455d(0x174)](_0x28455d(0x18c),!![]),calculateTotalCost()):Swal[_0x28455d(0x178)]({'icon':_0x28455d(0x185),'title':_0x28455d(0x16e),'text':'Jumlah\x20barang\x20yang\x20diminta\x20melebihi\x20stok\x20yang\x20tersedia.'});}),$(document)['on']('click',_0x1a10be(0x16b),function(){const _0xacd810=_0x1a10be;let _0x58bf39=$(this)[_0xacd810(0x197)](_0xacd810(0x14e)),_0x4bd16c=parseInt(_0x58bf39[_0xacd810(0x15c)]());_0x4bd16c>0x1&&(_0x4bd16c--,_0x58bf39[_0xacd810(0x15c)](_0x4bd16c),$(this)[_0xacd810(0x164)]('.card-body')[_0xacd810(0x159)](_0xacd810(0x169))[_0xacd810(0x174)]('checked',!![]),calculateTotalCost());}),$(document)['on']('change',_0x1a10be(0x169),function(){calculateTotalCost();});}function getAllCartUID(){const _0x2b5cbc=_0x1648c8;$[_0x2b5cbc(0x144)]({'url':'/api/carts','method':_0x2b5cbc(0x1a0),'success':function(_0x3f7b1e){const _0x1f17ca=_0x2b5cbc;_0x3f7b1e[_0x1f17ca(0x13f)]['forEach'](_0x364297=>{const _0x4857d7=_0x1f17ca;$(_0x4857d7(0x19c))[_0x4857d7(0x15b)](renderCartItem(_0x364297));});}});}function handleDeliveryOption(){const _0x15b373=_0x1648c8,_0x529a7e=$('#delivery-option')[_0x15b373(0x15c)]();_0x529a7e===_0x15b373(0x153)?($(_0x15b373(0x193))['show'](),calculateTotalCost()):($(_0x15b373(0x193))[_0x15b373(0x19b)](),$(_0x15b373(0x148))[_0x15b373(0x17e)](_0x15b373(0x177)),calculateTotalCost());}function handleSelectAll(){const _0x12aed0=_0x1648c8,_0x411cdd=$(_0x12aed0(0x196))['is'](_0x12aed0(0x165));$('.cart-checkbox')[_0x12aed0(0x174)]('checked',_0x411cdd),calculateTotalCost();}function calculateTotalCost(){const _0x4685f9=_0x1648c8;let _0x92a7d9=0x0,_0x16c00a=0x0;const _0x533897=$(_0x4685f9(0x168))[_0x4685f9(0x15c)]();$(_0x4685f9(0x189))[_0x4685f9(0x16a)](function(){const _0x1d8040=_0x4685f9,_0x11860a=$(this)['data']('id'),_0x55e42e=parseInt($(_0x1d8040(0x13a)+_0x11860a)['val']()),_0xdc8353=parseFloat($(_0x1d8040(0x13a)+_0x11860a)[_0x1d8040(0x164)](_0x1d8040(0x19d))[_0x1d8040(0x159)](_0x1d8040(0x19a))[_0x1d8040(0x17e)]()[_0x1d8040(0x156)]('Rp','')[_0x1d8040(0x156)](',','')),_0x14e68e=_0x55e42e*_0xdc8353;$('#total-price-'+_0x11860a)[_0x1d8040(0x17e)]('Rp\x20'+_0x14e68e[_0x1d8040(0x145)]()),_0x92a7d9+=_0x14e68e;}),_0x533897==='delivery'&&$('#cart-container\x20input[type=\x22checkbox\x22]:checked')[_0x4685f9(0x16a)](function(){const _0x1d2062=_0x4685f9,_0x1eb410=$(this)['data']('id'),_0x415857=parseInt($(_0x1d2062(0x13a)+_0x1eb410)[_0x1d2062(0x15c)]());_0x16c00a+=_0x415857*0x7d0;}),$('#delivery-cost')['text'](_0x4685f9(0x150)+_0x16c00a[_0x4685f9(0x145)]()),$(_0x4685f9(0x199))['text'](_0x4685f9(0x150)+(_0x92a7d9+_0x16c00a)[_0x4685f9(0x145)]());}function _0x2642(_0x4c3eac,_0x5d5cb1){const _0x450788=_0x4507();return _0x2642=function(_0x264203,_0x808447){_0x264203=_0x264203-0x137;let _0x33a0cb=_0x450788[_0x264203];return _0x33a0cb;},_0x2642(_0x4c3eac,_0x5d5cb1);}function validateCart(){const _0x43d015=_0x1648c8,_0x27f511=$(_0x43d015(0x168))['val']();if(!_0x27f511)return Swal[_0x43d015(0x178)](_0x43d015(0x173),_0x43d015(0x13e),'error'),![];return calculateTotalCost(),!![];}function deleteCartItem(_0x4c48c8){const _0x4c8175=_0x1648c8;Swal['fire']({'title':'Apakah\x20anda\x20yakin?','text':_0x4c8175(0x13b),'icon':_0x4c8175(0x18a),'showCancelButton':!![],'confirmButtonColor':_0x4c8175(0x192),'cancelButtonColor':_0x4c8175(0x190),'confirmButtonText':_0x4c8175(0x14f),'cancelButtonText':_0x4c8175(0x137)})[_0x4c8175(0x16d)](_0x21b305=>{const _0x2f98f9=_0x4c8175;_0x21b305[_0x2f98f9(0x18b)]&&$[_0x2f98f9(0x144)]({'url':_0x2f98f9(0x158)+_0x4c48c8,'method':_0x2f98f9(0x15f),'success':function(_0x554ff8){const _0x472e9a=_0x2f98f9;calculateTotalCost(),Swal['fire'](_0x472e9a(0x157),_0x554ff8['message'],'success')[_0x472e9a(0x16d)](()=>{const _0x1f46a8=_0x472e9a;window[_0x1f46a8(0x186)][_0x1f46a8(0x184)]();});},'error':function(_0x49b2f7,_0x37bfc1,_0x17dfeb){const _0x26067b=_0x2f98f9;Swal[_0x26067b(0x178)](_0x26067b(0x18d),_0x49b2f7['responseJSON'][_0x26067b(0x141)],_0x26067b(0x185));}});});}function cartCheckouts(){const _0x1de887=_0x1648c8;$(_0x1de887(0x13d))['on'](_0x1de887(0x163),function(){const _0x1caf10=_0x1de887;if(!validateCart())return;const _0x1b3dbf=[],_0x238eac=$('#delivery-option')[_0x1caf10(0x15c)]();let _0x2aa5ef=null;_0x238eac===_0x1caf10(0x153)&&(_0x2aa5ef=$('#u-alamat')['data']('id'));$(_0x1caf10(0x182))[_0x1caf10(0x16a)](function(){const _0x4bd5d8=_0x1caf10,_0x42bcc7=$(this)[_0x4bd5d8(0x13f)]('id'),_0x1de94e=$('#cart-qty-'+_0x42bcc7)[_0x4bd5d8(0x15c)](),_0x29c29=$(this)[_0x4bd5d8(0x164)]('.card')[_0x4bd5d8(0x13f)](_0x4bd5d8(0x17d)),_0x13c4ee=$(_0x4bd5d8(0x16f))[_0x4bd5d8(0x17e)](),_0x257cbb=parseFloat($(_0x4bd5d8(0x14a)+_0x42bcc7)['text']()[_0x4bd5d8(0x156)](/[Rp.,]/g,''));_0x1b3dbf[_0x4bd5d8(0x170)]({'product_id':_0x29c29,'quantity':_0x1de94e,'jenis_gas':_0x13c4ee,'total_harga':_0x257cbb});});if(_0x1b3dbf[_0x1caf10(0x14c)]===0x0){Swal['fire'](_0x1caf10(0x1a3),_0x1caf10(0x194),'error');return;}let _0x51e8fc=parseFloat($('#delivery-cost')[_0x1caf10(0x17e)]()[_0x1caf10(0x156)](/[Rp.,]/g,''));isNaN(_0x51e8fc)&&(_0x51e8fc=0x0),Swal['fire']({'title':_0x1caf10(0x149),'text':_0x1caf10(0x146),'icon':_0x1caf10(0x198),'showCancelButton':!![],'confirmButtonColor':_0x1caf10(0x192),'cancelButtonColor':_0x1caf10(0x190),'confirmButtonText':_0x1caf10(0x175)})[_0x1caf10(0x16d)](_0x205634=>{const _0x466a4b=_0x1caf10;_0x205634[_0x466a4b(0x18b)]&&$[_0x466a4b(0x144)]({'url':_0x466a4b(0x15e),'method':_0x466a4b(0x143),'contentType':_0x466a4b(0x162),'data':JSON[_0x466a4b(0x187)]({'cart':_0x1b3dbf,'delivery_method':_0x238eac,'alamat':_0x2aa5ef,'delivery_fee':_0x51e8fc}),'success':function(_0x213a28){const _0x4c5099=_0x466a4b;console['log']('Response\x20received:',_0x213a28);const _0x35c77e=_0x213a28[_0x4c5099(0x154)];_0x35c77e?window['snap'][_0x4c5099(0x15d)](_0x35c77e,{'onSuccess':function(_0x1bf7bb){const _0x29e9b4=_0x4c5099;console[_0x29e9b4(0x19f)](_0x29e9b4(0x138),_0x1bf7bb);},'onPending':function(_0x1b2a95){const _0x367ee4=_0x4c5099;console[_0x367ee4(0x19f)]('Waiting\x20for\x20payment:',_0x1b2a95);},'onError':function(_0x13a67f){const _0x4b2eff=_0x4c5099;console[_0x4b2eff(0x19f)]('Payment\x20error:',_0x13a67f);}}):console[_0x4c5099(0x185)](_0x4c5099(0x1a4));},'error':function(_0x37edf4,_0x4dcc41,_0x2eb360){const _0x2161c3=_0x466a4b;Swal[_0x2161c3(0x178)](_0x2161c3(0x18d),_0x37edf4[_0x2161c3(0x14d)][_0x2161c3(0x141)],_0x2161c3(0x185));}});});});}function getAlamat(){const _0x300f05=_0x1648c8;$[_0x300f05(0x144)]({'url':'/api/cart-alamat','method':'GET','success':function(_0x3a1014){const _0x181e06=_0x300f05;$(_0x181e06(0x171))[_0x181e06(0x188)]('data-id',_0x3a1014['data'][_0x181e06(0x1a1)]),console['log'](_0x3a1014[_0x181e06(0x13f)]);const _0x118039=_0x3a1014[_0x181e06(0x13f)][_0x181e06(0x16c)][_0x181e06(0x14c)]>0xa?_0x3a1014[_0x181e06(0x13f)][_0x181e06(0x16c)]['substring'](0x0,0x32)+'...':_0x3a1014[_0x181e06(0x13f)]['Detail_alamat'];$('#u-alamat')[_0x181e06(0x17e)](_0x118039);},'error':function(_0x52b76f,_0xe77d73,_0x5b7902){const _0x4019b4=_0x300f05;Swal[_0x4019b4(0x178)](_0x4019b4(0x18d),_0x52b76f[_0x4019b4(0x14d)][_0x4019b4(0x141)],_0x4019b4(0x185));}});}