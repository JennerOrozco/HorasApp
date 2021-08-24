import { TestBed } from '@angular/core/testing';
import { IntoGuard } from './into.guard';

describe('IntoGuard', () => {
  let guard: IntoGuard;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    guard = TestBed.inject(IntoGuard);
  });

  it('should be created', () => {
    expect(guard).toBeTruthy();
  });
});
