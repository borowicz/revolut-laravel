
@if(!isset($tickerChart)) @php($tickerChart = 'NASDAQ:AAPL') @endif

{{-- https://www.tradingview.com/widget-docs/widgets/charts/advanced-chart/ --}}
<!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container" style="height:100%;width:100%">
    <div class="tradingview-widget-container__widget" style="height:calc(100% - 32px);width:100%"></div>
    <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/" rel="noopener nofollow" target="_blank"><span class="blue-text">Track all markets on TradingView</span></a></div>
{{--    // "symbol": "NASDAQ:AAPL",--}}
    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
        {
            "height": "400",
            "autosize": true,
            "symbol": "{{ $tickerChart }}",
            "interval": "D",
            "timezone": "Etc/UTC",
            "theme": "light",
            "style": "1",
            "locale": "en",
            "allow_symbol_change": true,
            "calendar": false,
            "support_host": "https://www.tradingview.com"
        }
    </script>
</div>
<!-- TradingView Widget END -->
