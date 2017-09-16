<span class="grade">
@if(!$rate_count)
    @lang('fragment/utils/rate.no_rates')
@else
    <?php $i= 0 ?>
    @for($i; $i < floor($rate_avg); $i++)
        <span class="fa fa-star"></span>
    @endfor
    @if($i < 5 && ($rate_avg - $i) >= 0.80)
        <span class="fa fa-star"></span>
        <?php $i++ ?>
    @elseif($i < 5 && $rate_avg - $i >= 0.4 && $rate_avg - $i < 0.8)
        <span class="fa fa-star-half-o"></span>
        <?php $i++ ?>
    @endif
    @for($i; $i < 5; $i++)
        <span class="fa fa-star-o"></span>
    @endfor
@endif
</span>
