export function useAuthStore() {
  const tokenState = useState<string | null>("auth-token", () => null);

  function setToken(value: string | null) {
    tokenState.value = value;
  }

  return {
    get token() {
      return tokenState.value;
    },
    setToken,
    clearToken: () => setToken(null),
  };
}
