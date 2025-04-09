<!--================================-->
<!-- Color switcher Start -->
<!--================================-->
<div class="color-switcher show-color-switcher mt-5">
    <!--Color switcher Show/Hide button -->
    <a class="switcher-button"><i class="fa fa-clock-o fa-spin
    notification-count
{{--     wave in--}}
     "></i></a>
    <!-- Color switcher title -->
    <div class="color-switcher-title">
        <span class="tx-16 text-center">{{ __('quiz.employee.remaining_time') }}</span>
    </div>
    <!-- Colors style -->
    <div class="color-list text-center">
        <h3 id="remaining-time">{{ $item->remaining_time }}</h3>
    </div>
</div>
<!--/ Color switcher  End  -->
