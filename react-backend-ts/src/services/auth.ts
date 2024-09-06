export function getUsername(data: object): Promise<string> {
  return new Promise((resolve, reject) => {
    setTimeout(() => {
      if (Math.random() < 0.5) {
        console.log(data);
        resolve();
      } else {
        reject(new Error('Failed to get username'));
      }
    }, 1000);
  });
}
