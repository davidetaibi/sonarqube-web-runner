/*
 * SonarQube Runner - API
 * Copyright (C) 2011-2016 SonarSource SA
 * mailto:contact AT sonarsource DOT com
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program; if not, write to the Free Software Foundation,
 * Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
package org.sonar.runner.api;

import java.util.Scanner;

/**
 * Version of this sonar-runner API.
 *
 * @since 2.2
 */
public enum RunnerVersion {

  INSTANCE;

  private String version;

  private RunnerVersion() {
    Scanner scanner = new Scanner(getClass().getResourceAsStream("/org/sonar/runner/api/version.txt"), "UTF-8");
    try {
      this.version = scanner.next();
    } finally {
      scanner.close();
    }
  }

  public static String version() {
    return INSTANCE.version;
  }

}
