<style>
	.binance{
		padding: 5px;
		margin:0px auto 5px auto;
		background-color:#12161c;
		width:100%;
		height:55px;
		border:solid 1px #f0b90b;
		color:#f0b90b;
		cursor:pointer;
	}
	
	.binance-logo{
		width:25px;
		height:25px;
		float:left;
	}
	
	.binance-logo img{
		width:45px;
		height:45px;
	}
	.binance-title{
		font-weight:bold;
		font-size:15px;
	}
	.binance-content{
		text-align:center;
	}
</style>

<div class="binance" onClick="window.open('https://www.binance.com/{{ app()->getLocale() }}/register?ref=37462873', '_blank').focus();">
	<div class="binance-logo">
		<img src="/images/binance/logo.png" alt="binance">
	</div>
	<div class="binance-content">
		<div class="binance-title">
			Binance
		</div>
		<div class="binance-content">
			{{ __('ads/binance.The bigest cryptocurrency exchange') }}
		</div>
	</div>
</div>
