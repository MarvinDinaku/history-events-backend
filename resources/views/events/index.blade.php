@extends('events.layout')
     
@section('content')
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
     
   
    <div class="table-wrapper">
    <div class="table-title">
      <div class="row">
        <div class="col-sm-6">
          <h2>Events</h2>
        </div>
        <div class="col-sm-6">
          <a href="{{ route('events.create') }}" class="btn btn-success" data-toggle="modal"><span>Add New Event</span></a>
          
        </div>
      </div>
    </div>
    <table class="table table-striped table-hover">
        <tr>
            <th>No</th>
            <th>Image</th>
            <th>Date</th>
            <th>Name</th>
            <th>Description</th>
            <!-- <th>Event Type</th> -->
            <th>Years</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($events as $event)
        <tr>
            <td style="width:5%">{{ ++$i }}</td>
            <td style="width:14%"><img src="/images/{{ $event->image }}" width="100"></td>
            <td style="width:14%">{{ $event->date }}</td>
            <td style="width:14%">{{ $event->name }}</td>
            <td style="width:14%">{!! html_entity_decode($event->description) !!}</td>
            <!-- <td>{{ $event->event_type }}</td> -->
            <td style="width:14%">{{ $event->years }}</td>
            <td style="width:15%">
                <form class="d-flex flex-row justify-content-between" action="{{ route('events.destroy',$event->id) }}" method="POST">
     
                    <a class="btn btn-info" href="{{ route('events.show',$event->id) }}"><i class="bi bi-eye"></i></a>
      
                    <a class="btn btn-primary" href="{{ route('events.edit',$event->id) }}"><i class="bi bi-pencil"></i></a>
     
                    @csrf
                    @method('DELETE')
        
                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash3"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    
    {!! $events->links() !!}
        
@endsection