import { useState } from 'react';
import './App.scss';

export default function App() {
  const [count, setCount] = useState(0);

  return (
    <>
      <h1>Vite + React</h1>
      <div className="card">
        <button onClick={() => setCount((count) => count + 1)}>
          count is {count}
        </button>
        <p>
          Edit <code>src/App.tsx</code> and save to test HMR
        </p>
      </div>
      <p className="text-red-600">
        Click on the Vite and React logos to learn more
      </p>
    </>
  );
}
