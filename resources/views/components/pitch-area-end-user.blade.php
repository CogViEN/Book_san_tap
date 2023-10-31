<div class="col-md-10">
    <div class="card card-raised card-background"
        style="background-image: url('http://{{ $avatar }}'); margin-left: 77px">
        <div class="card-content">
            <h6 class="category text-info">{{ $address }}</h6>
            <h3 class="card-title">{{ $name }}</h3>
            <p class="card-description">
               <b>Include:</b> {{ $type }}
            </p>
            <h4 class="card-title">{{ $reference_price }}</h4>
            <a href="{{ route('end_user.detail', $id) }}" class="btn btn-primary btn-round">
                <i class="material-icons">subject</i> Book Appointment
            </a>
        </div>
    </div>
</div>