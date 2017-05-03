@layout('layout.head', ['title' => 'Welcome'])
    
    <main>
        
        <h1>Welcome</h1>
        
        <ul>
            <li>url: {{$data->url()}}</li>
        </ul>
        
    </main>
    
@layout('layout.foot')