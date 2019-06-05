<h1>Hello Search</h1>

@forelse($users as $user)
    <p>{{$user->first_name}}</p>
@empty
    <h1>No data</h1>
@endforelse
