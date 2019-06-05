<h1>Test presenter</h1>

@forelse($users as $user)
    <h1>Hello, {{ $user->present()->fullName }}</h1>
@empty
@endforelse
